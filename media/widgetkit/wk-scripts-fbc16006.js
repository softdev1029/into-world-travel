/*
This code is using a minfied version of https://github.com/googlemaps/js-marker-clusterer
*/
var WidgetkitMaps = WidgetkitMaps || [];
! function(t) {
    "use strict";

    function e(t, i, r) {
        this.extend(e, google.maps.OverlayView), this.map_ = t, this.markers_ = [], this.clusters_ = [], this.sizes = [53, 56, 66, 78, 90], this.styles_ = [], this.ready_ = false;
        var s = r || {};
        this.gridSize_ = s.gridSize || 60, this.minClusterSize_ = s.minimumClusterSize || 2, this.maxZoom_ = s.maxZoom || null, this.styles_ = s.styles || [], this.imagePath_ = s.imagePath || this.MARKER_CLUSTER_IMAGE_PATH_, this.imageExtension_ = s.imageExtension || this.MARKER_CLUSTER_IMAGE_EXTENSION_, this.zoomOnClick_ = true, void 0 != s.zoomOnClick && (this.zoomOnClick_ = s.zoomOnClick), this.averageCenter_ = false, void 0 != s.averageCenter && (this.averageCenter_ = s.averageCenter), this.setupStyles_(), this.setMap(t), this.prevZoom_ = this.map_.getZoom();
        var o = this;
        google.maps.event.addListener(this.map_, "zoom_changed", function() {
            var t = o.map_.getZoom();
            o.prevZoom_ != t && (o.prevZoom_ = t, o.resetViewport());
        }), google.maps.event.addListener(this.map_, "idle", function() {
            o.redraw();
        }), i && i.length && this.addMarkers(i, false);
    }

    function i(t) {
        this.markerClusterer_ = t, this.map_ = t.getMap(), this.gridSize_ = t.getGridSize(), this.minClusterSize_ = t.getMinClusterSize(), this.averageCenter_ = t.isAverageCenter(), this.center_ = null, this.markers_ = [], this.bounds_ = null, this.clusterIcon_ = new r(this, t.getStyles(), t.getGridSize());
    }

    function r(t, e, i) {
        t.getMarkerClusterer().extend(r, google.maps.OverlayView), this.styles_ = e, this.padding_ = i || 0, this.cluster_ = t, this.center_ = null, this.map_ = t.getMap(), this.div_ = null, this.sums_ = null, this.visible_ = false, this.setMap(this.map_)
    }
    var s, o = function() {
        return s || (s = t.Deferred(), window.wkInitializeGoogleMapsEx = s.resolve,t.getScript("//maps.google.com/maps/api/js?callback=wkInitializeGoogleMapsEx"+((mapexGoogleApiKey)?("&key="+mapexGoogleApiKey):""))), s.promise()
    };
    t(function() {
        t('script[type="widgetkit/mapex"]').each(function() {
            var i = t(this),
                r = t("<div></div>").attr(i.data()),
                s = JSON.parse(this.innerHTML);
            i.replaceWith(r), o().then(function() {
                var i, o, n, a, h, p = s.markers,
                    l = [],
					/*We add backward compatibility with orignial Yootheme's Map widget:*/
					c_sv = (typeof s.streetviewcontrol === 'boolean' ? s.streetviewcontrol : s.mapctrl),
					c_r = (typeof s.rotatecontrol === 'boolean' ? s.rotatecontrol : s.mapctrl),
					c_sc = (typeof s.scalecontrol === 'boolean' ? s.scalecontrol : s.mapctrl),
					m_style= ( ((typeof s.maptypecontrol_style === 'string') && (typeof google.maps.MapTypeControlStyle[s.maptypecontrol_style.toUpperCase()] != 'undefined')) ? google.maps.MapTypeControlStyle[s.maptypecontrol_style.toUpperCase()] : google.maps.MapTypeControlStyle.DROPDOWN_MENU),
					z_style = ( ((typeof s.zoom_style === 'string') && (typeof google.maps.ZoomControlStyle[s.zoom_style.toUpperCase()] != 'undefined')) ? google.maps.ZoomControlStyle[s.zoom_style.toUpperCase()] : google.maps.ZoomControlStyle.DEFAULT),
					map_style = ( ( (typeof s.styling_mode === 'string') && (s.styling_mode == 'json') && (typeof s.styling_json === 'string') ) ? s.styling_json : ''),
					mTypes = [];
				if (typeof s.show_styled === 'boolean' ? s.show_styled : true)
					mTypes.push('STYLED');
				if (typeof s.show_roadmap === 'boolean' ? s.show_roadmap : true)
					mTypes.push(google.maps.MapTypeId.ROADMAP);
				if (typeof s.show_satellite === 'boolean' ? s.show_satellite : true)
					mTypes.push(google.maps.MapTypeId.SATELLITE);
				if (typeof s.show_hybrid === 'boolean' ? s.show_hybrid : false)
					mTypes.push(google.maps.MapTypeId.HYBRID);
				if (typeof s.show_terrain === 'boolean' ? s.show_terrain : false)
					mTypes.push(google.maps.MapTypeId.TERRAIN);
				
                Object.keys(s).forEach(function(t) {
                    isNaN(s[t]) || (s[t] = Number(s[t]))
                }), n = ((typeof s.center_lat != 'undefined') && (typeof s.center_lng != 'undefined')) ? new google.maps.LatLng(s.center_lat, s.center_lng) : (p.length ? new google.maps.LatLng(p[0].lat, p[0].lng) : new google.maps.LatLng(-34.397, 150.644)), o = {
                    zoom: (typeof window["getMapZoom"+s.map_id2] === 'function') ? (window["getMapZoom"+s.map_id2]()) : parseInt(s.zoom, 10),
                    center: n,
                    scrollwheel: s.zoomwheel,
                    draggable: s.draggable,
					rotateControl : c_r,
					streetViewControl: c_sv,
                    mapTypeId: google.maps.MapTypeId[s.maptypeid.toUpperCase()],
                    mapTypeControl: s.maptypecontrol,
					scaleControl : c_sc,
                    zoomControl: s.zoomcontrol,
					/* Not working in the current Google Maps API:
					zoomControlOptions: {
						position: google.maps.ControlPosition.TOP_CENTER,
						style: z_style
					},
					*/
                    disableDefaultUI: s.disabledefaultui,
					/*adding custom tiles color*/
					backgroundColor: s.tiles_color,
                    mapTypeControlOptions: {
                        style: m_style,
                        mapTypeIds: mTypes
                    }
                }, i = new google.maps.Map(r[0], o), WidgetkitMapsAdd(s.map_id, i), p.length && s.directions && (a = t('<a target="_blank"></a>').css({
                    padding: "5px 1px",
                    "text-decoration": "none"
                }), h = t("<div></div>").css({
                    "-webkit-background-clip": "padding-box",
                    padding: "1px 4px",
                    backgroundColor: "white",
                    borderColor: "rgba(0, 0, 0, 0.14902)",
                    borderStyle: "solid",
                    borderWidth: "1px",
                    cursor: "pointer",
                    textAlign: "center",
                    fontFamily: "Roboto, Arial, sans-serif",
                    fontWeight: 500,
                    boxShadow: "rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px",
                    index: 1
                }), h.html('<span style="color:#000;"><span style="color:blue;">&#8627;</span> '+(typeof s.directionstext === 'string' ? s.directionstext : 'Get directions')+'</span>'), a.append(h), a.setHref = function(t, e) {
                    this.attr("href", "http://maps.google.com/?daddr=" + t + "," + e)
                }, i.controls[google.maps.ControlPosition.TOP_RIGHT].push(a[0])), p.length && s.marker && (p.forEach(function(t, e) {
					var mapOptions={
                        position: new google.maps.LatLng(t.lat, t.lng),
                        map: i,
                        title: t.title
                    };
					/*adding custom pin image*/
					if ( (typeof t.pin !== 'undefined') && (t.pin.length>0) ) {
						var img={};
						img['url']=t.pin;
						/*adding anchor*/
						if ( (typeof t.anchor_x === 'number') && (typeof t.anchor_y === 'number') ){
							img['anchor']=new google.maps.Point(t.anchor_x, t.anchor_y);
							// The origin for this image is (0, 0).
							img['origin']=new google.maps.Point(0,0);
						}
						mapOptions['icon']=img;
					}
                    var r, o = new google.maps.Marker(mapOptions);
					var html_content=jQuery("#"+t.id).html();
                    l.push(o);
					if (s.marker >= 1){
						r = new google.maps.InfoWindow({
							content: html_content,
							maxWidth: s.popup_max_width ? parseInt(s.popup_max_width, 10) : 300
						});
						google.maps.event.addListener(o, "click", function() {
							if (html_content) {
								var infowindow;
								if ( (s.marker==2) && (s.autohide) ){
									infowindow=getWidgetkitMapInfoWindow(s.map_id);
									if (!infowindow)
										infowindow=r;
									else
										infowindow.close();
								}
								else
									infowindow=r;
								r.open(i, o);
								if (a){
									a.setHref(t.lat, t.lng);
									a.show();
								}
								setWidgetkitMapInfoWindow(s.map_id,r);
							}
						});
                    }
					0 === e && (3 === s.marker && html_content && r.open(i, o), a && (a.setHref(t.lat, t.lng), a.show()));
                }), i.panTo(n)), s.markercluster && (this.markerCluster = new e(i, l, (s.markercluster=='custom') ? 
					{ 
						'gridSize' : s.cluster_gridSize,
						'maxZoom' : s.cluster_maxZoom,
						'minimumClusterSize' : s.cluster_minimumClusterSize,
						'styles' : s.clusterstyles
					} : null ));
                var u = new google.maps.StyledMapType( ( map_style.length > 0 ? JSON.parse(map_style) : [{
                    featureType: "all",
                    elementType: "all",
                    stylers: [{
                        invert_lightness: s.styler_invert_lightness
                    }, {
                        hue: s.styler_hue
                    }, {
                        saturation: s.styler_saturation
                    }, {
                        lightness: s.styler_lightness
                    }, {
                        gamma: s.styler_gamma
                    }]
					}]
					), {
                    name: ( ((typeof s.maptype_name === 'string') && (s.maptype_name.trim().length>0)) ? s.maptype_name : "Styled")
                });
                i.mapTypes.set("STYLED", u), "STYLED" == s.maptypeid.toUpperCase() && i.setMapTypeId("STYLED")
            })
        })
    }), e.prototype.MARKER_CLUSTER_IMAGE_PATH_ = "https://raw.githubusercontent.com/rvalitov/cluster-markers/master/images/standard/m", e.prototype.MARKER_CLUSTER_IMAGE_EXTENSION_ = "png", e.prototype.extend = function(t, e) {
        return function(t) {
            for (var e in t.prototype) this.prototype[e] = t.prototype[e];
            return this
        }.apply(t, [e])
    }, e.prototype.onAdd = function() {
        this.setReady_(true)
    }, e.prototype.draw = function() {}, e.prototype.setupStyles_ = function() {
        if (!this.styles_.length)
            for (var t, e = 0; t = this.sizes[e]; e++) this.styles_.push({
                url: this.imagePath_ + (e + 1) + "." + this.imageExtension_,
                height: t,
                width: t
            })
    }, e.prototype.fitMapToMarkers = function() {
        for (var t, e = this.getMarkers(), i = new google.maps.LatLngBounds, r = 0; t = e[r]; r++) i.extend(t.getPosition());
        this.map_.fitBounds(i)
    }, e.prototype.setStyles = function(t) {
        this.styles_ = t
    }, e.prototype.getStyles = function() {
        return this.styles_
    }, e.prototype.isZoomOnClick = function() {
        return this.zoomOnClick_
    }, e.prototype.isAverageCenter = function() {
        return this.averageCenter_
    }, e.prototype.getMarkers = function() {
        return this.markers_
    }, e.prototype.getTotalMarkers = function() {
        return this.markers_.length
    }, e.prototype.setMaxZoom = function(t) {
        this.maxZoom_ = t
    }, e.prototype.getMaxZoom = function() {
        return this.maxZoom_
    }, e.prototype.calculator_ = function(t, e) {
        for (var i = 0, r = t.length, s = r; 0 !== s;) s = parseInt(s / 10, 10), i++;
        return i = Math.min(i, e), {
            text: r,
            index: i
        }
    }, e.prototype.setCalculator = function(t) {
        this.calculator_ = t
    }, e.prototype.getCalculator = function() {
        return this.calculator_
    }, e.prototype.addMarkers = function(t, e) {
        for (var i, r = 0; i = t[r]; r++) this.pushMarkerTo_(i);
        e || this.redraw()
    }, e.prototype.pushMarkerTo_ = function(t) {
        if (t.isAdded = false, t.draggable) {
            var e = this;
            google.maps.event.addListener(t, "dragend", function() {
                t.isAdded = false, e.repaint()
            })
        }
        this.markers_.push(t)
    }, e.prototype.addMarker = function(t, e) {
        this.pushMarkerTo_(t), e || this.redraw()
    }, e.prototype.removeMarker_ = function(t) {
        var e = -1;
        if (this.markers_.indexOf) e = this.markers_.indexOf(t);
        else
            for (var i, r = 0; i = this.markers_[r]; r++)
                if (i == t) {
                    e = r;
                    break
                } return -1 == e ? false : (t.setMap(null), this.markers_.splice(e, 1), true)
    }, e.prototype.removeMarker = function(t, e) {
        var i = this.removeMarker_(t);
        return !e && i ? (this.resetViewport(), this.redraw(), true) : false
    }, e.prototype.removeMarkers = function(t, e) {
        for (var i, r = false, s = 0; i = t[s]; s++) {
            var o = this.removeMarker_(i);
            r = r || o
        }
        return !e && r ? (this.resetViewport(), this.redraw(), true) : void 0
    }, e.prototype.setReady_ = function(t) {
        this.ready_ || (this.ready_ = t, this.createClusters_())
    }, e.prototype.getTotalClusters = function() {
        return this.clusters_.length
    }, e.prototype.getMap = function() {
        return this.map_
    }, e.prototype.setMap = function(t) {
        this.map_ = t
    }, e.prototype.getGridSize = function() {
        return this.gridSize_
    }, e.prototype.setGridSize = function(t) {
        this.gridSize_ = t
    }, e.prototype.getMinClusterSize = function() {
        return this.minClusterSize_
    }, e.prototype.setMinClusterSize = function(t) {
        this.minClusterSize_ = t
    }, e.prototype.getExtendedBounds = function(t) {
        var e = this.getProjection(),
            i = new google.maps.LatLng(t.getNorthEast().lat(), t.getNorthEast().lng()),
            r = new google.maps.LatLng(t.getSouthWest().lat(), t.getSouthWest().lng()),
            s = e.fromLatLngToDivPixel(i);
        s.x += this.gridSize_, s.y -= this.gridSize_;
        var o = e.fromLatLngToDivPixel(r);
        o.x -= this.gridSize_, o.y += this.gridSize_;
        var n = e.fromDivPixelToLatLng(s),
            a = e.fromDivPixelToLatLng(o);
        return t.extend(n), t.extend(a), t
    }, e.prototype.isMarkerInBounds_ = function(t, e) {
        return e.contains(t.getPosition())
    }, e.prototype.clearMarkers = function() {
        this.resetViewport(true), this.markers_ = []
    }, e.prototype.resetViewport = function(t) {
        for (var e, i = 0; e = this.clusters_[i]; i++) e.remove();
        for (var r, i = 0; r = this.markers_[i]; i++) r.isAdded = false, t && r.setMap(null);
        this.clusters_ = []
    }, e.prototype.repaint = function() {
        var t = this.clusters_.slice();
        this.clusters_.length = 0, this.resetViewport(), this.redraw(), window.setTimeout(function() {
            for (var e, i = 0; e = t[i]; i++) e.remove()
        }, 0)
    }, e.prototype.redraw = function() {
        this.createClusters_()
    }, e.prototype.distanceBetweenPoints_ = function(t, e) {
        if (!t || !e) return 0;
        var i = 6371,
            r = (e.lat() - t.lat()) * Math.PI / 180,
            s = (e.lng() - t.lng()) * Math.PI / 180,
            o = Math.sin(r / 2) * Math.sin(r / 2) + Math.cos(t.lat() * Math.PI / 180) * Math.cos(e.lat() * Math.PI / 180) * Math.sin(s / 2) * Math.sin(s / 2),
            n = 2 * Math.atan2(Math.sqrt(o), Math.sqrt(1 - o)),
            a = i * n;
        return a
    }, e.prototype.addToClosestCluster_ = function(t) {
        for (var e, r = 4e4, s = null, o = (t.getPosition(), 0); e = this.clusters_[o]; o++) {
            var n = e.getCenter();
            if (n) {
                var a = this.distanceBetweenPoints_(n, t.getPosition());
                r > a && (r = a, s = e)
            }
        }
        if (s && s.isMarkerInClusterBounds(t)) s.addMarker(t);
        else {
            var e = new i(this);
            e.addMarker(t), this.clusters_.push(e)
        }
    }, e.prototype.createClusters_ = function() {
        if (this.ready_)
            for (var t, e = new google.maps.LatLngBounds(this.map_.getBounds().getSouthWest(), this.map_.getBounds().getNorthEast()), i = this.getExtendedBounds(e), r = 0; t = this.markers_[r]; r++) !t.isAdded && this.isMarkerInBounds_(t, i) && this.addToClosestCluster_(t)
    }, i.prototype.isMarkerAlreadyAdded = function(t) {
        if (this.markers_.indexOf) return -1 != this.markers_.indexOf(t);
        for (var e, i = 0; e = this.markers_[i]; i++)
            if (e == t) return true;
        return false
    }, i.prototype.addMarker = function(t) {
        if (this.isMarkerAlreadyAdded(t)) return false;
        if (this.center_) {
            if (this.averageCenter_) {
                var e = this.markers_.length + 1,
                    i = (this.center_.lat() * (e - 1) + t.getPosition().lat()) / e,
                    r = (this.center_.lng() * (e - 1) + t.getPosition().lng()) / e;
                this.center_ = new google.maps.LatLng(i, r), this.calculateBounds_()
            }
        } else this.center_ = t.getPosition(), this.calculateBounds_();
        t.isAdded = true, this.markers_.push(t);
        var s = this.markers_.length;
        if (s < this.minClusterSize_ && t.getMap() != this.map_ && t.setMap(this.map_), s == this.minClusterSize_)
            for (var o = 0; s > o; o++) this.markers_[o].setMap(null);
        return s >= this.minClusterSize_ && t.setMap(null), this.updateIcon(), true
    }, i.prototype.getMarkerClusterer = function() {
        return this.markerClusterer_
    }, i.prototype.getBounds = function() {
        for (var t, e = new google.maps.LatLngBounds(this.center_, this.center_), i = this.getMarkers(), r = 0; t = i[r]; r++) e.extend(t.getPosition());
        return e
    }, i.prototype.remove = function() {
        this.clusterIcon_.remove(), this.markers_.length = 0, delete this.markers_
    }, i.prototype.getSize = function() {
        return this.markers_.length
    }, i.prototype.getMarkers = function() {
        return this.markers_
    }, i.prototype.getCenter = function() {
        return this.center_
    }, i.prototype.calculateBounds_ = function() {
        var t = new google.maps.LatLngBounds(this.center_, this.center_);
        this.bounds_ = this.markerClusterer_.getExtendedBounds(t)
    }, i.prototype.isMarkerInClusterBounds = function(t) {
        return this.bounds_.contains(t.getPosition())
    }, i.prototype.getMap = function() {
        return this.map_
    }, i.prototype.updateIcon = function() {
        var t = this.map_.getZoom(),
            e = this.markerClusterer_.getMaxZoom();
        if (e && t > e)
            for (var i, r = 0; i = this.markers_[r]; r++) i.setMap(this.map_);
        else {
            if (this.markers_.length < this.minClusterSize_) return void this.clusterIcon_.hide();
            var s = this.markerClusterer_.getStyles().length,
                o = this.markerClusterer_.getCalculator()(this.markers_, s);
            this.clusterIcon_.setCenter(this.center_), this.clusterIcon_.setSums(o), this.clusterIcon_.show()
        }
    }, r.prototype.triggerClusterClick = function() {
        var t = this.cluster_.getMarkerClusterer();
        google.maps.event.trigger(t, "clusterclick", this.cluster_), t.isZoomOnClick() && this.map_.fitBounds(this.cluster_.getBounds())
    }, r.prototype.onAdd = function() {
        if (this.div_ = document.createElement("DIV"), this.visible_) {
            var t = this.getPosFromLatLng_(this.center_);
            this.div_.style.cssText = this.createCss(t), this.div_.innerHTML = this.sums_.text
        }
        var e = this.getPanes();
        e.overlayMouseTarget.appendChild(this.div_);
        var i = this;
        google.maps.event.addDomListener(this.div_, "click", function() {
            i.triggerClusterClick()
        })
    }, r.prototype.getPosFromLatLng_ = function(t) {
        var e = this.getProjection().fromLatLngToDivPixel(t);
		if (this.iconAnchor_ && typeof this.iconAnchor_ === 'object' && this.iconAnchor_.length === 2) {
			e.x -= this.iconAnchor_[0];
			e.y -= this.iconAnchor_[1];
		} else {
			e.x -= parseInt(this.width_ / 2, 10);
			e.y -= parseInt(this.height_ / 2, 10);
		}
        return e;
    }, r.prototype.draw = function() {
        if (this.visible_) {
            var t = this.getPosFromLatLng_(this.center_);
            this.div_.style.top = t.y + "px", this.div_.style.left = t.x + "px"
        }
    }, r.prototype.hide = function() {
        this.div_ && (this.div_.style.display = "none"), this.visible_ = false
    }, r.prototype.show = function() {
        if (this.div_) {
            var t = this.getPosFromLatLng_(this.center_);
            this.div_.style.cssText = this.createCss(t), this.div_.style.display = ""
        }
        this.visible_ = true
    }, r.prototype.remove = function() {
        this.setMap(null)
    }, r.prototype.onRemove = function() {
        this.div_ && this.div_.parentNode && (this.hide(), this.div_.parentNode.removeChild(this.div_), this.div_ = null)
    }, r.prototype.setSums = function(t) {
        this.sums_ = t, this.text_ = t.text, this.index_ = t.index, this.div_ && (this.div_.innerHTML = t.text), this.useStyle()
    }, r.prototype.useStyle = function() {
        var t = Math.max(0, this.sums_.index - 1);
        t = Math.min(this.styles_.length - 1, t);
        var e = this.styles_[t];
        this.url_ = e.url;
		this.height_ = e.height;
		this.width_ = e.width;
		this.textColor_ = e.textColor;
		this.anchor_ = e.anchor;
		this.iconAnchor_ = e.iconAnchor;
		this.textSize_ = e.textSize;
		this.backgroundPosition_ = e.backgroundPosition;
    }, r.prototype.setCenter = function(t) {
        this.center_ = t
    }, r.prototype.createCss = function(t) {
        var e = [];
        e.push("background-image:url(" + this.url_ + ");");
        var i = this.backgroundPosition_ ? this.backgroundPosition_ : "0 0";
        e.push("background-position:" + i + ";");
		if (this.anchor_ && typeof this.anchor_ === 'object' && this.anchor_.length === 2) {
			if (typeof this.anchor_[0] === 'number' && this.anchor_[0] > 0 && this.anchor_[0] < this.height_)
				/*Small trick: we add line-height normal here because otherwise it may inherit css of the website template*/
				e.push('height:' + (this.height_ - this.anchor_[0]) + 'px; padding-top:' + this.anchor_[0] + 'px;line-height:normal;');
			else 
				if (typeof this.anchor_[0] === 'number' && this.anchor_[0] < 0 && - this.anchor_[0] < this.height_)
					e.push('height:' + this.height_ + 'px; line-height:' + (this.height_ + this.anchor_[0]) + 'px;');
				else
					e.push('height:' + this.height_ + 'px; line-height:' + this.height_ + 'px;');
			if (typeof this.anchor_[1] === 'number' && this.anchor_[1] > 0 && this.anchor_[1] < this.width_)
				e.push('width:' + (this.width_ - this.anchor_[1]) + 'px; padding-left:' + this.anchor_[1] + 'px;');
			else
				e.push('width:' + this.width_ + 'px; text-align:center;');
		} 
		else
			e.push('height:' + this.height_ + 'px; line-height:' + this.height_ + 'px; width:' + this.width_ + 'px; text-align:center;');

        var r = this.textColor_ ? this.textColor_ : "black",
            s = this.textSize_ ? this.textSize_ : 11;
        return e.push("cursor:pointer; top:" + t.y + "px; left:" + t.x + "px; color:" + r + "; position:absolute; font-size:" + s + "px; font-family:Arial,sans-serif; font-weight:bold"), e.join("")
    }
}(jQuery);

function WidgetkitMapsObj(id, map) {
    this.id = id;
    this.map = map;
	this.infowindow=null;
}
function WidgetkitMapsAdd(id, map){
	if (id)
		WidgetkitMaps.push(new WidgetkitMapsObj(id,map));
}
function getWidgetkitMap(id){
	if (!WidgetkitMaps)
		return null;
	for (var i=0; i<WidgetkitMaps.length; i++)
		if (WidgetkitMaps[i].id==id){
			return WidgetkitMaps[i].map;
		}
	return null;
}
function getWidgetkitMapInfoWindow(id){
	if (!WidgetkitMaps)
		return null;
	for (var i=0; i<WidgetkitMaps.length; i++)
		if (WidgetkitMaps[i].id==id){
			return WidgetkitMaps[i].infowindow;
		}
	return null;
}
function setWidgetkitMapInfoWindow(id,infowindow){
	if (!WidgetkitMaps)
		return null;
	for (var i=0; i<WidgetkitMaps.length; i++)
		if (WidgetkitMaps[i].id==id){
			WidgetkitMaps[i].infowindow=infowindow;
			return;
		}
}

!function(t){"use strict";function e(t,i,r){this.extend(e,google.maps.OverlayView),this.map_=t,this.markers_=[],this.clusters_=[],this.sizes=[53,56,66,78,90],this.styles_=[],this.ready_=!1;var s=r||{};this.gridSize_=s.gridSize||60,this.minClusterSize_=s.minimumClusterSize||2,this.maxZoom_=s.maxZoom||null,this.styles_=s.styles||[],this.imagePath_=s.imagePath||this.MARKER_CLUSTER_IMAGE_PATH_,this.imageExtension_=s.imageExtension||this.MARKER_CLUSTER_IMAGE_EXTENSION_,this.zoomOnClick_=!0,void 0!=s.zoomOnClick&&(this.zoomOnClick_=s.zoomOnClick),this.averageCenter_=!1,void 0!=s.averageCenter&&(this.averageCenter_=s.averageCenter),this.setupStyles_(),this.setMap(t),this.prevZoom_=this.map_.getZoom();var o=this;google.maps.event.addListener(this.map_,"zoom_changed",function(){var t=o.map_.getZoom();o.prevZoom_!=t&&(o.prevZoom_=t,o.resetViewport())}),google.maps.event.addListener(this.map_,"idle",function(){o.redraw()}),i&&i.length&&this.addMarkers(i,!1)}function i(t){this.markerClusterer_=t,this.map_=t.getMap(),this.gridSize_=t.getGridSize(),this.minClusterSize_=t.getMinClusterSize(),this.averageCenter_=t.isAverageCenter(),this.center_=null,this.markers_=[],this.bounds_=null,this.clusterIcon_=new r(this,t.getStyles(),t.getGridSize())}function r(t,e,i){t.getMarkerClusterer().extend(r,google.maps.OverlayView),this.styles_=e,this.padding_=i||0,this.cluster_=t,this.center_=null,this.map_=t.getMap(),this.div_=null,this.sums_=null,this.visible_=!1,this.setMap(this.map_)}var s,o=function(){return s||(s=t.Deferred(),window.wkInitializeGoogleMapsApi=s.resolve,t.getScript("//maps.google.com/maps/api/js?callback=wkInitializeGoogleMapsApi&key="+(window.GOOGLE_MAPS_API_KEY||""))),s.promise()};t(function(){t('script[type="widgetkit/map"]').each(function(){var i=t(this),r=t("<div data-uk-check-display data-wk-check-display></div>").attr(i.data()),s=JSON.parse(this.innerHTML);i.replaceWith(r),o().then(function(){var i,o,n,a,h,p=s.markers,l=[],u=window.MapsMarkerHelper||!1;Object.keys(s).forEach(function(t){isNaN(s[t])||(s[t]=Number(s[t]))}),n=p.length?new google.maps.LatLng(p[0].lat,p[0].lng):new google.maps.LatLng((-34.397),150.644),o={zoom:parseInt(s.zoom,10),center:n,streetViewControl:s.mapctrl,navigationControl:s.mapctrl,scrollwheel:s.zoomwheel,draggable:s.draggable,mapTypeId:google.maps.MapTypeId[s.maptypeid.toUpperCase()],mapTypeControl:s.maptypecontrol,zoomControl:s.zoomcontrol,disableDefaultUI:s.disabledefaultui,mapTypeControlOptions:{style:google.maps.MapTypeControlStyle.DROPDOWN_MENU,mapTypeIds:["styled_map",google.maps.MapTypeId.ROADMAP,google.maps.MapTypeId.SATELLITE]},zoomControlOptions:{style:s.mapctrl?google.maps.ZoomControlStyle.DEFAULT:google.maps.ZoomControlStyle.SMALL}},i=new google.maps.Map(r[0],o),r.data("googlemap",i).on("display.uk.check",function(){google.maps.event.trigger(i,"resize")}),p.length&&s.directions&&(a=t('<a target="_blank"></a>').css({padding:"5px 1px","text-decoration":"none"}),h=t("<div></div>").css({"-webkit-background-clip":"padding-box",padding:"1px 4px",backgroundColor:"white",borderColor:"rgba(0, 0, 0, 0.14902)",borderStyle:"solid",borderWidth:"1px",cursor:"pointer",textAlign:"center",fontFamily:"Roboto, Arial, sans-serif",fontWeight:500,boxShadow:"rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px",index:1}),h.html('<span style="color:#000;"><span style="color:blue;">&#8627;</span>'+(s.directionsText||"Get Directions")+"</span>"),a.append(h),a.setHref=function(t,e){this.attr("href","http://maps.google.com/?daddr="+t+","+e)},i.controls[google.maps.ControlPosition.TOP_RIGHT].push(a[0])),p.length&&s.marker&&(p.forEach(function(t,e){var r,o=new google.maps.Marker({position:new google.maps.LatLng(t.lat,t.lng),map:i,title:t.title});(u&&t.icon||s.marker_icon)&&u.setIcon(o,t.icon||s.marker_icon),l.push(o),s.marker>=1&&(r=new google.maps.InfoWindow({content:t.content,maxWidth:s.popup_max_width?parseInt(s.popup_max_width,10):300}),google.maps.event.addListener(o,"click",function(){t.content&&r.open(i,o),a&&(a.setHref(t.lat,t.lng),a.show())}),0===e&&(3===s.marker&&t.content&&r.open(i,o),a&&(a.setHref(t.lat,t.lng),a.show())))}),i.panTo(new google.maps.LatLng(p[0].lat,p[0].lng))),s.markercluster&&(this.markerCluster=new e(i,l));var g=new google.maps.StyledMapType([{featureType:"all",elementType:"all",stylers:[{invert_lightness:s.styler_invert_lightness},{hue:s.styler_hue},{saturation:s.styler_saturation},{lightness:s.styler_lightness},{gamma:s.styler_gamma}]}],{name:"Styled"});i.mapTypes.set("styled_map",g),"ROADMAP"==s.maptypeid.toUpperCase()&&i.setMapTypeId("styled_map")})})}),e.prototype.MARKER_CLUSTER_IMAGE_PATH_="https://raw.githubusercontent.com/googlemaps/js-marker-clusterer/gh-pages/images/m",e.prototype.MARKER_CLUSTER_IMAGE_EXTENSION_="png",e.prototype.extend=function(t,e){return function(t){for(var e in t.prototype)this.prototype[e]=t.prototype[e];return this}.apply(t,[e])},e.prototype.onAdd=function(){this.setReady_(!0)},e.prototype.draw=function(){},e.prototype.setupStyles_=function(){if(!this.styles_.length)for(var t,e=0;t=this.sizes[e];e++)this.styles_.push({url:this.imagePath_+(e+1)+"."+this.imageExtension_,height:t,width:t})},e.prototype.fitMapToMarkers=function(){for(var t,e=this.getMarkers(),i=new google.maps.LatLngBounds,r=0;t=e[r];r++)i.extend(t.getPosition());this.map_.fitBounds(i)},e.prototype.setStyles=function(t){this.styles_=t},e.prototype.getStyles=function(){return this.styles_},e.prototype.isZoomOnClick=function(){return this.zoomOnClick_},e.prototype.isAverageCenter=function(){return this.averageCenter_},e.prototype.getMarkers=function(){return this.markers_},e.prototype.getTotalMarkers=function(){return this.markers_.length},e.prototype.setMaxZoom=function(t){this.maxZoom_=t},e.prototype.getMaxZoom=function(){return this.maxZoom_},e.prototype.calculator_=function(t,e){for(var i=0,r=t.length,s=r;0!==s;)s=parseInt(s/10,10),i++;return i=Math.min(i,e),{text:r,index:i}},e.prototype.setCalculator=function(t){this.calculator_=t},e.prototype.getCalculator=function(){return this.calculator_},e.prototype.addMarkers=function(t,e){for(var i,r=0;i=t[r];r++)this.pushMarkerTo_(i);e||this.redraw()},e.prototype.pushMarkerTo_=function(t){if(t.isAdded=!1,t.draggable){var e=this;google.maps.event.addListener(t,"dragend",function(){t.isAdded=!1,e.repaint()})}this.markers_.push(t)},e.prototype.addMarker=function(t,e){this.pushMarkerTo_(t),e||this.redraw()},e.prototype.removeMarker_=function(t){var e=-1;if(this.markers_.indexOf)e=this.markers_.indexOf(t);else for(var i,r=0;i=this.markers_[r];r++)if(i==t){e=r;break}return e!=-1&&(t.setMap(null),this.markers_.splice(e,1),!0)},e.prototype.removeMarker=function(t,e){var i=this.removeMarker_(t);return!(e||!i)&&(this.resetViewport(),this.redraw(),!0)},e.prototype.removeMarkers=function(t,e){for(var i,r=!1,s=0;i=t[s];s++){var o=this.removeMarker_(i);r=r||o}if(!e&&r)return this.resetViewport(),this.redraw(),!0},e.prototype.setReady_=function(t){this.ready_||(this.ready_=t,this.createClusters_())},e.prototype.getTotalClusters=function(){return this.clusters_.length},e.prototype.getMap=function(){return this.map_},e.prototype.setMap=function(t){this.map_=t},e.prototype.getGridSize=function(){return this.gridSize_},e.prototype.setGridSize=function(t){this.gridSize_=t},e.prototype.getMinClusterSize=function(){return this.minClusterSize_},e.prototype.setMinClusterSize=function(t){this.minClusterSize_=t},e.prototype.getExtendedBounds=function(t){var e=this.getProjection(),i=new google.maps.LatLng(t.getNorthEast().lat(),t.getNorthEast().lng()),r=new google.maps.LatLng(t.getSouthWest().lat(),t.getSouthWest().lng()),s=e.fromLatLngToDivPixel(i);s.x+=this.gridSize_,s.y-=this.gridSize_;var o=e.fromLatLngToDivPixel(r);o.x-=this.gridSize_,o.y+=this.gridSize_;var n=e.fromDivPixelToLatLng(s),a=e.fromDivPixelToLatLng(o);return t.extend(n),t.extend(a),t},e.prototype.isMarkerInBounds_=function(t,e){return e.contains(t.getPosition())},e.prototype.clearMarkers=function(){this.resetViewport(!0),this.markers_=[]},e.prototype.resetViewport=function(t){for(var e,i=0;e=this.clusters_[i];i++)e.remove();for(var r,i=0;r=this.markers_[i];i++)r.isAdded=!1,t&&r.setMap(null);this.clusters_=[]},e.prototype.repaint=function(){var t=this.clusters_.slice();this.clusters_.length=0,this.resetViewport(),this.redraw(),window.setTimeout(function(){for(var e,i=0;e=t[i];i++)e.remove()},0)},e.prototype.redraw=function(){this.createClusters_()},e.prototype.distanceBetweenPoints_=function(t,e){if(!t||!e)return 0;var i=6371,r=(e.lat()-t.lat())*Math.PI/180,s=(e.lng()-t.lng())*Math.PI/180,o=Math.sin(r/2)*Math.sin(r/2)+Math.cos(t.lat()*Math.PI/180)*Math.cos(e.lat()*Math.PI/180)*Math.sin(s/2)*Math.sin(s/2),n=2*Math.atan2(Math.sqrt(o),Math.sqrt(1-o)),a=i*n;return a},e.prototype.addToClosestCluster_=function(t){for(var e,r=4e4,s=null,o=(t.getPosition(),0);e=this.clusters_[o];o++){var n=e.getCenter();if(n){var a=this.distanceBetweenPoints_(n,t.getPosition());a<r&&(r=a,s=e)}}if(s&&s.isMarkerInClusterBounds(t))s.addMarker(t);else{var e=new i(this);e.addMarker(t),this.clusters_.push(e)}},e.prototype.createClusters_=function(){if(this.ready_)for(var t,e=new google.maps.LatLngBounds(this.map_.getBounds().getSouthWest(),this.map_.getBounds().getNorthEast()),i=this.getExtendedBounds(e),r=0;t=this.markers_[r];r++)!t.isAdded&&this.isMarkerInBounds_(t,i)&&this.addToClosestCluster_(t)},i.prototype.isMarkerAlreadyAdded=function(t){if(this.markers_.indexOf)return this.markers_.indexOf(t)!=-1;for(var e,i=0;e=this.markers_[i];i++)if(e==t)return!0;return!1},i.prototype.addMarker=function(t){if(this.isMarkerAlreadyAdded(t))return!1;if(this.center_){if(this.averageCenter_){var e=this.markers_.length+1,i=(this.center_.lat()*(e-1)+t.getPosition().lat())/e,r=(this.center_.lng()*(e-1)+t.getPosition().lng())/e;this.center_=new google.maps.LatLng(i,r),this.calculateBounds_()}}else this.center_=t.getPosition(),this.calculateBounds_();t.isAdded=!0,this.markers_.push(t);var s=this.markers_.length;if(s<this.minClusterSize_&&t.getMap()!=this.map_&&t.setMap(this.map_),s==this.minClusterSize_)for(var o=0;o<s;o++)this.markers_[o].setMap(null);return s>=this.minClusterSize_&&t.setMap(null),this.updateIcon(),!0},i.prototype.getMarkerClusterer=function(){return this.markerClusterer_},i.prototype.getBounds=function(){for(var t,e=new google.maps.LatLngBounds(this.center_,this.center_),i=this.getMarkers(),r=0;t=i[r];r++)e.extend(t.getPosition());return e},i.prototype.remove=function(){this.clusterIcon_.remove(),this.markers_.length=0,delete this.markers_},i.prototype.getSize=function(){return this.markers_.length},i.prototype.getMarkers=function(){return this.markers_},i.prototype.getCenter=function(){return this.center_},i.prototype.calculateBounds_=function(){var t=new google.maps.LatLngBounds(this.center_,this.center_);this.bounds_=this.markerClusterer_.getExtendedBounds(t)},i.prototype.isMarkerInClusterBounds=function(t){return this.bounds_.contains(t.getPosition())},i.prototype.getMap=function(){return this.map_},i.prototype.updateIcon=function(){var t=this.map_.getZoom(),e=this.markerClusterer_.getMaxZoom();if(e&&t>e)for(var i,r=0;i=this.markers_[r];r++)i.setMap(this.map_);else{if(this.markers_.length<this.minClusterSize_)return void this.clusterIcon_.hide();var s=this.markerClusterer_.getStyles().length,o=this.markerClusterer_.getCalculator()(this.markers_,s);this.clusterIcon_.setCenter(this.center_),this.clusterIcon_.setSums(o),this.clusterIcon_.show()}},r.prototype.triggerClusterClick=function(){var t=this.cluster_.getMarkerClusterer();google.maps.event.trigger(t,"clusterclick",this.cluster_),t.isZoomOnClick()&&this.map_.fitBounds(this.cluster_.getBounds())},r.prototype.onAdd=function(){if(this.div_=document.createElement("DIV"),this.visible_){var t=this.getPosFromLatLng_(this.center_);this.div_.style.cssText=this.createCss(t),this.div_.innerHTML=this.sums_.text}var e=this.getPanes();e.overlayMouseTarget.appendChild(this.div_);var i=this;google.maps.event.addDomListener(this.div_,"click",function(){i.triggerClusterClick()})},r.prototype.getPosFromLatLng_=function(t){var e=this.getProjection().fromLatLngToDivPixel(t);return e.x-=parseInt(this.width_/2,10),e.y-=parseInt(this.height_/2,10),e},r.prototype.draw=function(){if(this.visible_){var t=this.getPosFromLatLng_(this.center_);this.div_.style.top=t.y+"px",this.div_.style.left=t.x+"px"}},r.prototype.hide=function(){this.div_&&(this.div_.style.display="none"),this.visible_=!1},r.prototype.show=function(){if(this.div_){var t=this.getPosFromLatLng_(this.center_);this.div_.style.cssText=this.createCss(t),this.div_.style.display=""}this.visible_=!0},r.prototype.remove=function(){this.setMap(null)},r.prototype.onRemove=function(){this.div_&&this.div_.parentNode&&(this.hide(),this.div_.parentNode.removeChild(this.div_),this.div_=null)},r.prototype.setSums=function(t){this.sums_=t,this.text_=t.text,this.index_=t.index,this.div_&&(this.div_.innerHTML=t.text),this.useStyle()},r.prototype.useStyle=function(){var t=Math.max(0,this.sums_.index-1);t=Math.min(this.styles_.length-1,t);var e=this.styles_[t];this.url_=e.url,this.height_=e.height,this.width_=e.width,this.textColor_=e.textColor,this.anchor_=e.anchor,this.textSize_=e.textSize,this.backgroundPosition_=e.backgroundPosition},r.prototype.setCenter=function(t){this.center_=t},r.prototype.createCss=function(t){var e=[];e.push("background-image:url("+this.url_+");");var i=this.backgroundPosition_?this.backgroundPosition_:"0 0";e.push("background-position:"+i+";"),"object"==typeof this.anchor_?("number"==typeof this.anchor_[0]&&this.anchor_[0]>0&&this.anchor_[0]<this.height_?e.push("height:"+(this.height_-this.anchor_[0])+"px; padding-top:"+this.anchor_[0]+"px;"):e.push("height:"+this.height_+"px; line-height:"+this.height_+"px;"),"number"==typeof this.anchor_[1]&&this.anchor_[1]>0&&this.anchor_[1]<this.width_?e.push("width:"+(this.width_-this.anchor_[1])+"px; padding-left:"+this.anchor_[1]+"px;"):e.push("width:"+this.width_+"px; text-align:center;")):e.push("height:"+this.height_+"px; line-height:"+this.height_+"px; width:"+this.width_+"px; text-align:center;");var r=this.textColor_?this.textColor_:"black",s=this.textSize_?this.textSize_:11;return e.push("cursor:pointer; top:"+t.y+"px; left:"+t.x+"px; color:"+r+"; position:absolute; font-size:"+s+"px; font-family:Arial,sans-serif; font-weight:bold"),e.join("")}}(jQuery);

var MapsMarkerHelper={colors:{black:[0,0,0,1],blue:[0,0,255,1],brown:[165,42,42,1],cyan:[0,255,255,1],fuchsia:[255,0,255,1],gold:[255,215,0,1],green:[0,128,0,1],indigo:[75,0,130,1],khaki:[240,230,140,1],lime:[0,255,0,1],magenta:[255,0,255,1],maroon:[128,0,0,1],navy:[0,0,128,1],olive:[128,128,0,1],orange:[255,165,0,1],pink:[255,192,203,1],purple:[128,0,128,1],violet:[128,0,128,1],red:[255,0,0,1],silver:[192,192,192,1],white:[255,255,255,1],yellow:[255,255,0,1],transparent:[255,255,255,0]},getSVG:function(e,s){return e=this.parseColor(e||"#E65857"),s=this.parseColor(s||"rgba(255,255,255,0)"),'<?xml version="1.0" encoding="utf-8"?>            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"             width="22px" height="34px" viewBox="0 0 22 34" enable-background="new 0 0 22 34" xml:space="preserve">             <circle id="circle" fill="'+s+'" cx="11" cy="11" r="6.5"/>            <path id="path" d="M11,0C4.94,0,0,4.876,0,10.9C0,19.458,11,34,11,34s11-14.581,11-23.1C22,4.876,17.061,0,11,0z M11,16.5             c-3.038,0-5.5-2.463-5.5-5.5c0-3.038,2.462-5.5,5.5-5.5c3.037,0,5.5,2.462,5.5,5.5C16.5,14.037,14.037,16.5,11,16.5z" fill="'+e+'"/>            </svg>'},parseColor:function(e){var s,a;return a=(s=/#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})/.exec(e))?[parseInt(s[1],16),parseInt(s[2],16),parseInt(s[3],16),1]:(s=/#([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])/.exec(e))?[17*parseInt(s[1],16),17*parseInt(s[2],16),17*parseInt(s[3],16),1]:(s=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(e))?[parseInt(s[1]),parseInt(s[2]),parseInt(s[3]),1]:(s=/rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9\.]*)\s*\)/.exec(e))?[parseInt(s[1],10),parseInt(s[2],10),parseInt(s[3],10),parseFloat(s[4])]:this.colors[e]||[230,88,87,1],"rgba("+a[0]+", "+a[1]+", "+a[2]+", "+a[3]+")"},setIcon:function(e,s){var a,r=new google.maps.Point(11,40),t=function(){e.setIcon({url:a,anchor:r})};if(!s.trim())return a="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi.png",t();if(s.indexOf("/")!=-1){var n=new Image;n.onload=function(){a=n.src,r=new google.maps.Point(Math.ceil(n.width/2),n.height),t()},n.onerror=function(){return a="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi.png",t()},n.src=s}else a="data:image/svg+xml;base64,"+btoa(this.getSVG.apply(this,s.split(" "))),r=new google.maps.Point(11,34),t()}};

