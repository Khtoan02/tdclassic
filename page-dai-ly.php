<?php
/**
 * Template Name: Trang Đại lý
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
                    
                    <?php
                    $agents = new WP_Query(array(
                        'post_type' => 'agent',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ));

                    if ($agents->have_posts()) : ?>
                        <div class="agents-list" id="agentsList">
                            <?php while ($agents->have_posts()) : $agents->the_post(); 
                                $address = get_post_meta(get_the_ID(), '_agent_address', true);
                                $phone = get_post_meta(get_the_ID(), '_agent_phone', true);
                                $email = get_post_meta(get_the_ID(), '_agent_email', true);
                                $google_maps_link = get_post_meta(get_the_ID(), '_agent_google_maps_link', true);
                            ?>
                                <div class="agent-item" data-maps-link="<?php echo esc_attr($google_maps_link); ?>">
                                    <div class="agent-card">
                                        <div class="agent-info">
                                            <h5 class="agent-name"><?php the_title(); ?></h5>
                                            <?php if ($address) : ?>
                                                <p class="agent-address">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <?php echo esc_html($address); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <div class="agent-contacts">
                                                <?php if ($phone) : ?>
                                                    <p class="agent-phone">
                                                        <i class="fas fa-phone"></i>
                                                        <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a>
                                                    </p>
                                                <?php endif; ?>
                                                
                                                <?php if ($email) : ?>
                                                    <p class="agent-email">
                                                        <i class="fas fa-envelope"></i>
                                                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="agent-actions">
                                            <button class="btn btn-primary btn-sm view-on-map" data-maps-link="<?php echo esc_attr($google_maps_link); ?>">
                                                <i class="fas fa-map"></i> Xem trên bản đồ
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-info">
                            <p>Chưa có đại lý nào được thêm vào hệ thống.</p>
                        </div>
                    <?php endif; 
                    wp_reset_postdata(); ?>
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
        // No API key configured
        document.getElementById('googleMap').innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f8f9fa; color: #666;"><p>Vui lòng cấu hình Google Maps API Key trong Admin Settings</p></div>';
    <?php endif; ?>
});
</script>

<?php get_footer(); ?> 