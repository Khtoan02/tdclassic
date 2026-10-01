/**
 * TD Classic Performance & Diagnostics Admin Script
 */

jQuery(document).ready(function($) {
    'use strict';

    // Show toast message
    function showToast(message, isError) {
        var $toast = $('#td-toast');
        $toast.text(message);
        $toast.css({
            'background': isError ? '#c5221f' : '#1d2327',
            'display': 'block',
            'opacity': '0'
        }).animate({ opacity: 1 }, 200);

        setTimeout(function() {
            $toast.animate({ opacity: 0 }, 300, function() {
                $toast.hide();
            });
        }, 3500);
    }

    // 1. Copy Report for AI
    $('#btn-copy-ai-report').on('click', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var origText = $btn.html();

        $btn.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Đang tạo báo cáo...');

        $.ajax({
            url: tdDiagnostics.ajax_url,
            type: 'POST',
            data: {
                action: 'tdclassic_export_diagnostics',
                nonce: tdDiagnostics.nonce
            },
            success: function(res) {
                $btn.prop('disabled', false).html(origText);
                if (res.success && res.data) {
                    var data = res.data;
                    var markdown = formatReportForAI(data);

                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(markdown).then(function() {
                            showToast('✅ Đã sao chép báo cáo máy chủ vào clipboard! Bạn có thể dán trực tiếp cho AI.');
                        }).catch(function() {
                            fallbackCopyText(markdown);
                        });
                    } else {
                        fallbackCopyText(markdown);
                    }
                } else {
                    showToast('❌ Không thể lấy dữ liệu báo cáo.', true);
                }
            },
            error: function() {
                $btn.prop('disabled', false).html(origText);
                showToast('❌ Lỗi kết nối máy chủ.', true);
            }
        });
    });

    // Fallback copy
    function fallbackCopyText(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showToast('✅ Đã sao chép báo cáo máy chủ vào clipboard!');
        } catch (err) {
            showToast('❌ Trình duyệt không hỗ trợ tự sao chép.', true);
        }
        document.body.removeChild(textArea);
    }

    // Format AI Report
    function formatReportForAI(data) {
        var h = data.host_specs || {};
        var p = data.performance || {};
        var e = data.errors || {};

        var text = "### 📊 BÁO CÁO HIỆU NĂNG & MÔI TRƯỜNG HOST (TD CLASSIC)\n\n";
        text += "- **Website:** " + data.site_url + "\n";
        text += "- **Thời gian xuất:** " + data.generated_at + "\n\n";

        text += "#### 1. Cấu hình Máy Chủ (Host Environment)\n";
        text += "- **Web Server:** " + (h.server_software || 'N/A') + "\n";
        text += "- **PHP Version:** " + (h.php_version || 'N/A') + " (Memory: " + (h.php_memory_limit || 'N/A') + ", Max Execution: " + (h.max_execution_time || 'N/A') + ")\n";
        text += "- **MySQL/MariaDB:** " + (h.mysql_version || 'N/A') + " (Ping DB: " + (h.db_latency_ms || 0) + "ms)\n";
        text += "- **OPcache:** " + (h.opcache && h.opcache.enabled ? "BẬT (" + h.opcache.used_memory_mb + "MB RAM)" : "TẮT") + "\n";
        text += "- **LiteSpeed Cache Plugin:** " + (h.litespeed_cache_plugin ? "Đã kích hoạt" : "Chưa cài/Chưa kích hoạt") + "\n";
        text += "- **Loopback Ping:** " + (h.loopback_test ? h.loopback_test.status + " (" + h.loopback_test.time_ms + "ms)" : "N/A") + "\n";
        text += "- **Active Plugins (" + (h.active_plugins_count || 0) + "):** " + (h.active_plugins_list ? h.active_plugins_list.join(', ') : 'None') + "\n\n";

        text += "#### 2. Thống Kê Tốc Độ Tải Trang (RUM)\n";
        text += "- **Tổng số lượt đo:** " + (p.total_samples || 0) + " mẫu\n";
        text += "- **Server sinh HTML (TTFB):** " + (p.avg_server_ms || 0) + "ms\n";
        text += "- **Client TTFB trung bình:** " + (p.avg_client_ttfb_ms || 0) + "ms\n";
        text += "- **DOM Ready trung bình:** " + (p.avg_dom_ready_ms || 0) + "ms\n";
        text += "- **Load Time trung bình:** " + (p.avg_load_time_ms || 0) + "ms\n";
        text += "- **LCP trung bình:** " + ((p.avg_lcp_ms || 0) / 1000).toFixed(2) + "s (CLS: " + (p.avg_cls || 0) + ")\n\n";

        if (p.slowest_pages && p.slowest_pages.length > 0) {
            text += "##### Top 5 Trang Chậm Nhất:\n";
            p.slowest_pages.forEach(function(sp) {
                text += "- `" + sp.url + "`: Load ~" + Math.round(sp.avg_load) + "ms (Server ~" + Math.round(sp.avg_server) + "ms, " + sp.hits + " lượt)\n";
            });
            text += "\n";
        }

        text += "#### 3. Bắt Lỗi & File Hỏng (" + (e.total_logged || 0) + " lỗi)\n";
        if (e.recent_errors && e.recent_errors.length > 0) {
            e.recent_errors.forEach(function(err) {
                text += "- [" + err.error_type + " - " + err.status_code + "] `" + err.target_url + "` tại `" + err.page_url + "` (" + err.created_at + ")\n";
            });
        } else {
            text += "- Không có file hỏng hoặc lỗi 404 nào được ghi nhận.\n";
        }

        return text;
    }

    // 2. Export JSON File
    $('#btn-export-json').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: tdDiagnostics.ajax_url,
            type: 'POST',
            data: {
                action: 'tdclassic_export_diagnostics',
                nonce: tdDiagnostics.nonce
            },
            success: function(res) {
                if (res.success && res.data) {
                    var jsonStr = JSON.stringify(res.data, null, 2);
                    var blob = new Blob([jsonStr], { type: "application/json" });
                    var url = URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'tdclassic-diagnostics-' + Date.now() + '.json';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                    showToast('✅ Đã tải file JSON chẩn đoán!');
                }
            }
        });
    });

    // 3. Clear Perf Logs
    $('#btn-clear-perf').on('click', function(e) {
        e.preventDefault();
        if (!confirm('Bạn có chắc chắn muốn xóa toàn bộ lịch sử đo tốc độ không?')) {
            return;
        }

        $.ajax({
            url: tdDiagnostics.ajax_url,
            type: 'POST',
            data: {
                action: 'tdclassic_clear_perf_logs',
                nonce: tdDiagnostics.nonce
            },
            success: function(res) {
                if (res.success) {
                    showToast('✅ Đã xóa toàn bộ lịch sử đo tốc độ!');
                    setTimeout(function() { location.reload(); }, 600);
                }
            }
        });
    });

    // 4. Clear Error Logs
    $('#btn-clear-errors').on('click', function(e) {
        e.preventDefault();
        if (!confirm('Bạn có chắc chắn muốn xóa toàn bộ lịch sử lỗi 404 và file hỏng không?')) {
            return;
        }

        $.ajax({
            url: tdDiagnostics.ajax_url,
            type: 'POST',
            data: {
                action: 'tdclassic_clear_error_logs',
                nonce: tdDiagnostics.nonce
            },
            success: function(res) {
                if (res.success) {
                    showToast('✅ Đã xóa toàn bộ lịch sử lỗi!');
                    setTimeout(function() { location.reload(); }, 600);
                }
            }
        });
    });

    // 5. Run 1-Click Site Health Audit
    $('#btn-start-full-audit').on('click', function(e) {
        e.preventDefault();

        var pages = tdDiagnostics.pages_to_audit || [];
        if (pages.length === 0) {
            showToast('Không tìm thấy danh sách trang cần kiểm tra.', true);
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).addClass('button-disabled');

        var $progressWrap = $('#td-audit-progress-container');
        var $progressFill = $('#td-audit-progress-fill');
        var $progressText = $('#td-audit-status-text');
        var $resultsBody = $('#td-audit-results-body');

        $progressWrap.show();
        $progressFill.css('width', '5%');
        $progressText.text('Bắt đầu chẩn đoán...');
        $resultsBody.empty();

        var currentIndex = 0;

        function auditNextPage() {
            if (currentIndex >= pages.length) {
                $progressFill.css('width', '100%');
                $progressText.text('✅ Hoàn tất kiểm tra ' + pages.length + ' trang!');
                $btn.prop('disabled', false).removeClass('button-disabled');
                showToast('✅ Quét toàn diện hoàn tất! Kiểm tra kết quả bên dưới.');
                return;
            }

            var item = pages[currentIndex];
            var pct = Math.round(((currentIndex) / pages.length) * 100);
            $progressFill.css('width', pct + '%');
            $progressText.text('Đang quét: ' + item.title + ' (' + item.url + ')...');

            $.ajax({
                url: tdDiagnostics.ajax_url,
                type: 'POST',
                data: {
                    action: 'tdclassic_run_audit_page',
                    nonce: tdDiagnostics.nonce,
                    url: item.url
                },
                success: function(res) {
                    if (res.success && res.data) {
                        var d = res.data;
                        var rowHtml = '<tr>';
                        rowHtml += '<td><strong>' + item.title + '</strong><br><a href="' + item.url + '" target="_blank" class="td-link-url" style="font-size: 11px;">' + item.url + '</a></td>';

                        // HTTP Code
                        var statusBadge = d.status_code === 200 ? 'td-badge-success' : 'td-badge-danger';
                        rowHtml += '<td><span class="td-badge ' + statusBadge + '">' + d.status_code + '</span></td>';

                        // TTFB
                        var ttfbBadge = d.fetch_time_ms < 400 ? 'td-badge-success' : (d.fetch_time_ms < 1000 ? 'td-badge-warning' : 'td-badge-danger');
                        rowHtml += '<td><span class="td-badge ' + ttfbBadge + '">' + d.fetch_time_ms + ' ms</span></td>';

                        // Size
                        rowHtml += '<td>' + d.body_size_kb + ' KB</td>';

                        // Compression
                        var isGzip = d.content_encoding && d.content_encoding !== 'none';
                        rowHtml += '<td><span class="td-badge ' + (isGzip ? 'td-badge-success' : 'td-badge-warning') + '">' + d.content_encoding + '</span></td>';

                        // LiteSpeed Cache
                        var isCached = d.litespeed_cache && d.litespeed_cache.indexOf('hit') !== -1;
                        rowHtml += '<td><span class="td-badge ' + (isCached ? 'td-badge-success' : 'td-badge-secondary') + '">' + d.litespeed_cache + '</span></td>';

                        // Broken assets
                        if (d.broken_assets && d.broken_assets.length > 0) {
                            var brokenList = '<div class="td-text-danger" style="font-weight: 600;">⚠️ Có ' + d.broken_assets.length + ' file hỏng!</div>';
                            d.broken_assets.forEach(function(b) {
                                brokenList += '<div style="margin-top: 4px;"><span class="td-badge td-badge-danger">' + b.status + '</span> <code class="td-code-broken">' + b.url + '</code></div>';
                            });
                            rowHtml += '<td>' + brokenList + '</td>';
                        } else {
                            rowHtml += '<td class="td-text-success"><span class="dashicons dashicons-yes-alt"></span> ' + d.assets_checked + ' file CSS/JS/Ảnh hoàn toàn ổn định</td>';
                        }

                        rowHtml += '</tr>';
                        $resultsBody.append(rowHtml);
                    } else {
                        var errHtml = '<tr><td><strong>' + item.title + '</strong></td><td colspan="6" class="td-text-danger">Lỗi kết nối kiểm tra: ' + (res.data ? res.data.error_message : 'Unknown') + '</td></tr>';
                        $resultsBody.append(errHtml);
                    }

                    currentIndex++;
                    setTimeout(auditNextPage, 400); // 400ms delay between audits
                },
                error: function() {
                    var errHtml = '<tr><td><strong>' + item.title + '</strong></td><td colspan="6" class="td-text-danger">Không thể gửi request đến admin-ajax</td></tr>';
                    $resultsBody.append(errHtml);
                    currentIndex++;
                    setTimeout(auditNextPage, 400);
                }
            });
        }

        auditNextPage();
    });
});
