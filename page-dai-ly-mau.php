<?php
/**
 * Template Name: Trang Đại lý Mẫu
 */

get_header(); ?>

<div class="container-fluid py-5">
    <div class="container">
        <!-- Page Header -->
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="display-4 text-center mb-3">Hệ thống Đại lý TD Classic</h1>
                <p class="lead text-center text-muted">Tìm kiếm đại lý gần bạn nhất</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Agents List - Left Side -->
            <div class="col-lg-4">
                <div class="agents-list-container">
                    <h3 class="mb-4">Danh sách Đại lý</h3>
                    
                    <!-- Sample Agents for Testing -->
                    <div class="agents-list" id="agentsList">
                        <div class="agent-item" data-maps-link="https://maps.google.com/?q=21.0278,105.8342">
                            <div class="agent-card">
                                <div class="agent-info">
                                    <h5 class="agent-name">Đại lý TD Classic Hà Nội</h5>
                                    <p class="agent-address">
                                        <i class="fas fa-map-marker-alt"></i>
                                        123 Đường Trần Hưng Đạo, Quận Hoàn Kiếm, Hà Nội
                                    </p>
                                    <div class="agent-contacts">
                                        <p class="agent-phone">
                                            <i class="fas fa-phone"></i>
                                            <a href="tel:02412345678">024 1234 5678</a>
                                        </p>
                                        <p class="agent-email">
                                            <i class="fas fa-envelope"></i>
                                            <a href="mailto:hanoi@tdclassic.com">hanoi@tdclassic.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="agent-actions">
                                    <button class="btn btn-primary btn-sm view-on-map" data-maps-link="https://maps.google.com/?q=21.0278,105.8342">
                                        <i class="fas fa-map"></i> Xem trên bản đồ
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="agent-item" data-maps-link="https://maps.google.com/?q=10.7769,106.7009">
                            <div class="agent-card">
                                <div class="agent-info">
                                    <h5 class="agent-name">Đại lý TD Classic TP.HCM</h5>
                                    <p class="agent-address">
                                        <i class="fas fa-map-marker-alt"></i>
                                        456 Đường Nguyễn Huệ, Quận 1, TP.HCM
                                    </p>
                                    <div class="agent-contacts">
                                        <p class="agent-phone">
                                            <i class="fas fa-phone"></i>
                                            <a href="tel:02898765432">028 9876 5432</a>
                                        </p>
                                        <p class="agent-email">
                                            <i class="fas fa-envelope"></i>
                                            <a href="mailto:hcm@tdclassic.com">hcm@tdclassic.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="agent-actions">
                                    <button class="btn btn-primary btn-sm view-on-map" data-maps-link="https://maps.google.com/?q=10.7769,106.7009">
                                        <i class="fas fa-map"></i> Xem trên bản đồ
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="agent-item" data-maps-link="https://maps.google.com/?q=16.0475,108.2062">
                            <div class="agent-card">
                                <div class="agent-info">
                                    <h5 class="agent-name">Đại lý TD Classic Đà Nẵng</h5>
                                    <p class="agent-address">
                                        <i class="fas fa-map-marker-alt"></i>
                                        789 Đường Lê Duẩn, Quận Hải Châu, Đà Nẵng
                                    </p>
                                    <div class="agent-contacts">
                                        <p class="agent-phone">
                                            <i class="fas fa-phone"></i>
                                            <a href="tel:023655556666">0236 5555 6666</a>
                                        </p>
                                        <p class="agent-email">
                                            <i class="fas fa-envelope"></i>
                                            <a href="mailto:danang@tdclassic.com">danang@tdclassic.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="agent-actions">
                                    <button class="btn btn-primary btn-sm view-on-map" data-maps-link="https://maps.google.com/?q=16.0475,108.2062">
                                        <i class="fas fa-map"></i> Xem trên bản đồ
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="agent-item" data-maps-link="https://maps.google.com/?q=10.0452,105.7469">
                            <div class="agent-card">
                                <div class="agent-info">
                                    <h5 class="agent-name">Đại lý TD Classic Cần Thơ</h5>
                                    <p class="agent-address">
                                        <i class="fas fa-map-marker-alt"></i>
                                        321 Đường Nguyễn Văn Linh, Quận Ninh Kiều, Cần Thơ
                                    </p>
                                    <div class="agent-contacts">
                                        <p class="agent-phone">
                                            <i class="fas fa-phone"></i>
                                            <a href="tel:029277778888">0292 7777 8888</a>
                                        </p>
                                        <p class="agent-email">
                                            <i class="fas fa-envelope"></i>
                                            <a href="mailto:cantho@tdclassic.com">cantho@tdclassic.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="agent-actions">
                                    <button class="btn btn-primary btn-sm view-on-map" data-maps-link="https://maps.google.com/?q=10.0452,105.7469">
                                        <i class="fas fa-map"></i> Xem trên bản đồ
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="agent-item" data-maps-link="https://maps.google.com/?q=16.4637,107.5909">
                            <div class="agent-card">
                                <div class="agent-info">
                                    <h5 class="agent-name">Đại lý TD Classic Huế</h5>
                                    <p class="agent-address">
                                        <i class="fas fa-map-marker-alt"></i>
                                        654 Đường Lê Lợi, TP. Huế, Thừa Thiên Huế
                                    </p>
                                    <div class="agent-contacts">
                                        <p class="agent-phone">
                                            <i class="fas fa-phone"></i>
                                            <a href="tel:023499990000">0234 9999 0000</a>
                                        </p>
                                        <p class="agent-email">
                                            <i class="fas fa-envelope"></i>
                                            <a href="mailto:hue@tdclassic.com">hue@tdclassic.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="agent-actions">
                                    <button class="btn btn-primary btn-sm view-on-map" data-maps-link="https://maps.google.com/?q=16.4637,107.5909">
                                        <i class="fas fa-map"></i> Xem trên bản đồ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Maps - Right Side -->
            <div class="col-lg-8">
                <div class="maps-container">
                    <h3 class="mb-4">Bản đồ</h3>
                    <div class="map-wrapper">
                        <div id="googleMap" class="google-map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.agents-list-container {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    height: 600px;
    overflow-y: auto;
}

.agents-list {
    max-height: 500px;
    overflow-y: auto;
}

.agent-item {
    margin-bottom: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.agent-item:hover {
    transform: translateY(-2px);
}

.agent-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border-left: 4px solid #007bff;
    transition: all 0.3s ease;
}

.agent-card:hover {
    background: #e9ecef;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.agent-name {
    color: #333;
    margin-bottom: 8px;
    font-weight: 600;
}

.agent-address {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.agent-contacts {
    margin-bottom: 10px;
}

.agent-contacts p {
    margin-bottom: 5px;
    font-size: 0.85rem;
}

.agent-contacts a {
    color: #007bff;
    text-decoration: none;
}

.agent-contacts a:hover {
    text-decoration: underline;
}

.agent-actions {
    text-align: right;
}

.maps-container {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.map-wrapper {
    position: relative;
    height: 500px;
    border-radius: 8px;
    overflow: hidden;
}

.google-map {
    width: 100%;
    height: 100%;
    border-radius: 8px;
}

.agent-item.active .agent-card {
    background: #007bff;
    color: white;
}

.agent-item.active .agent-name,
.agent-item.active .agent-address,
.agent-item.active .agent-contacts a {
    color: white;
}

@media (max-width: 991.98px) {
    .agents-list-container {
        height: auto;
        margin-bottom: 20px;
    }
    
    .map-wrapper {
        height: 400px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Google Maps
    let map;
    let markers = [];
    
    // Function to initialize map
    function initMap() {
        // Default center (Vietnam)
        const defaultCenter = { lat: 16.0475, lng: 108.2062 };
        
        map = new google.maps.Map(document.getElementById('googleMap'), {
            zoom: 6,
            center: defaultCenter,
            styles: [
                {
                    featureType: 'poi',
                    elementType: 'labels',
                    stylers: [{ visibility: 'off' }]
                }
            ]
        });
        
        // Add markers for all agents
        const agentItems = document.querySelectorAll('.agent-item');
        agentItems.forEach(function(item, index) {
            const mapsLink = item.getAttribute('data-maps-link');
            if (mapsLink) {
                // Extract coordinates from Google Maps link
                const coords = extractCoordinatesFromLink(mapsLink);
                if (coords) {
                    const marker = new google.maps.Marker({
                        position: coords,
                        map: map,
                        title: item.querySelector('.agent-name').textContent,
                        label: (index + 1).toString()
                    });
                    
                    // Add info window
                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div style="padding: 10px;">
                                <h6>${item.querySelector('.agent-name').textContent}</h6>
                                <p style="margin: 5px 0;">${item.querySelector('.agent-address').textContent}</p>
                            </div>
                        `
                    });
                    
                    marker.addListener('click', function() {
                        infoWindow.open(map, marker);
                    });
                    
                    markers.push(marker);
                }
            }
        });
    }
    
    // Function to extract coordinates from Google Maps link
    function extractCoordinatesFromLink(link) {
        // Handle different Google Maps link formats
        let coords = null;
        
        // Format: https://maps.google.com/?q=lat,lng
        const qMatch = link.match(/[?&]q=([^&]+)/);
        if (qMatch) {
            const coordsStr = decodeURIComponent(qMatch[1]);
            const coordsMatch = coordsStr.match(/(-?\d+\.\d+),(-?\d+\.\d+)/);
            if (coordsMatch) {
                coords = {
                    lat: parseFloat(coordsMatch[1]),
                    lng: parseFloat(coordsMatch[2])
                };
            }
        }
        
        // Format: https://maps.google.com/maps?ll=lat,lng
        const llMatch = link.match(/[?&]ll=([^&]+)/);
        if (llMatch && !coords) {
            const coordsStr = llMatch[1];
            const coordsMatch = coordsStr.match(/(-?\d+\.\d+),(-?\d+\.\d+)/);
            if (coordsMatch) {
                coords = {
                    lat: parseFloat(coordsMatch[1]),
                    lng: parseFloat(coordsMatch[2])
                };
            }
        }
        
        return coords;
    }
    
    // Handle agent item clicks
    document.querySelectorAll('.agent-item').forEach(function(item) {
        item.addEventListener('click', function() {
            // Remove active class from all items
            document.querySelectorAll('.agent-item').forEach(function(el) {
                el.classList.remove('active');
            });
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Get maps link
            const mapsLink = this.getAttribute('data-maps-link');
            if (mapsLink && map) {
                const coords = extractCoordinatesFromLink(mapsLink);
                if (coords) {
                    // Center map on selected agent
                    map.setCenter(coords);
                    map.setZoom(15);
                    
                    // Find and open info window for this marker
                    const agentName = this.querySelector('.agent-name').textContent;
                    markers.forEach(function(marker) {
                        if (marker.getTitle() === agentName) {
                            google.maps.event.trigger(marker, 'click');
                        }
                    });
                }
            }
        });
    });
    
    // Handle "View on Map" button clicks
    document.querySelectorAll('.view-on-map').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const mapsLink = this.getAttribute('data-maps-link');
            if (mapsLink) {
                window.open(mapsLink, '_blank');
            }
        });
    });
    
    // Load Google Maps API
    <?php 
    $api_key = get_option('tdclassic_google_maps_api_key');
    if ($api_key) : ?>
        // API key is loaded via WordPress enqueue
        if (typeof google !== 'undefined') {
            initMap();
        }
    <?php else : ?>
        // No API key configured - show sample map
        document.getElementById('googleMap').innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f8f9fa; color: #666;"><p>Vui lòng cấu hình Google Maps API Key trong Admin Settings</p></div>';
    <?php endif; ?>
});
</script>

<?php get_footer(); ?> 