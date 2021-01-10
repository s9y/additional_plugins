const dateToColor = date => {
	const minDate = new Date(date.getFullYear(), date.getMonth() - 1, 0);
	const maxDate = new Date(date.getFullYear(), date.getMonth(), 0);
	return "hsl(" + ((date.getTime() - minDate.getTime()) / (maxDate.getTime() - minDate.getTime())) + "turn, 100%, 50%)"
};

window.addEventListener("load", () => {
	document.querySelectorAll("div.map").forEach(divMap => {
		const popup = document.createElement("div");
		popup.setAttribute("class", "ol-popup");
		popup.onclick = () => {
			overlay.setPosition(undefined);
		};

		const overlay = new ol.Overlay({
			element: popup
		});

		const data = divMap.dataset;
		const entries = geo.entries.filter(x => ["all", "none"].includes(data.category) || x.categories.includes(parseInt(data.category)));
		const uploads = geo.uploads.filter(x => data.path.split("\n").some(y => x.url.startsWith(y)));
		const features = entries.map((entry, id) => {
			const feature = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat(entry.pos.reverse())));
			feature.setId(id);
			return feature;
		});

		const osmSource = new ol.source.OSM();
		const layers = [
			new ol.layer.Tile({source: osmSource, preload: Infinity}),
			new ol.layer.Vector({
				source: new ol.source.Vector({features: features}),
				style: feature => {
					const id = feature.getId();
					const entry = entries[id];
					const date = new Date(entry.date * 1000);

					return new ol.style.Style({
						image: new ol.style.Circle({
							radius: 6,
							fill: new ol.style.Fill({color: dateToColor(date)})
						})
					});
				},
				zIndex: Infinity
			})
		];
		for (const upload of uploads) {
			const source = new ol.source.Vector({
				url: upload.url,
				format: new ol.format.GPX()
			});
			source.on("featuresloadend", event => {
				upload.length = event.features
					.filter(feature => feature.getGeometry().getType() === "MultiLineString")
					.map(feature => ol.sphere.getLength(feature.getGeometry()))
					.reduce((a, b) => a + b, 0);
			});
			const layer = new ol.layer.Vector({
				source: source,
				style: feature => feature.getGeometry().getType() === "MultiLineString"
					? new ol.style.Style({
						stroke: new ol.style.Stroke({
							color: dateToColor(new Date(upload.date * 1000)),
							width: 3,
							lineDash: upload.date * 1000 > Date.now() ? [3, 6] : undefined
						})
					})
					: undefined
			});
			layers.push(layer);
		}
		const map = new ol.Map({
			controls: ol.control.defaults({rotate: false}).extend([
				new ol.control.FullScreen(),
				new ol.control.OverviewMap({
					layers: [
						new ol.layer.Tile({source: osmSource})
					]
				}),
				new ol.control.ScaleLine({
					bar: true,
					minWidth: 120
				})
			]),
			interactions: ol.interaction.defaults({
				altShiftDragRotate: false,
				pinchRotate: false
			}),
			layers: layers,
			overlays: [overlay],
			target: divMap,
			view: new ol.View({
				center: ol.proj.fromLonLat([data.longitude, data.latitude]),
				zoom: data.zoom
			})
		});

		map.on("singleclick", event => {
			const makeItem = object => {
				const title = document.createTextNode(object.title);
				const li = document.createElement("li");
				li.appendChild(object.url !== null
					? (() => {
						const a = document.createElement("a");
						a.appendChild(title);
						a.setAttribute("href", object.url);
						a.setAttribute("title",
							(object.author !== undefined ? object.author + ", " : "")
							+
							new Date(object.date * 1000).toLocaleString(undefined, {year: "numeric", month: "long", day: "2-digit", hour: "2-digit", minute: "2-digit"})
							+
							(object.length !== undefined ? ", " + (object.length / 1000).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + "km" : "")
						);
						return a;
					})()
					: title
				)
				return li;
			};

			const foundEntries = [];
			const foundUploads = [];
			map.forEachFeatureAtPixel(event.pixel, (feature, layer) => {
				const id = feature.getId();
				if (id !== undefined) {
					foundEntries.push(id);
				} else {
					const url = layer.getSource().getUrl();
					const id = uploads.findIndex(upload => upload.url === url);
					foundUploads.push(id);
				}
			}, {hitTolerance: 10});
			foundEntries.sort((x, y) => x - y);
			foundUploads.sort((x, y) => x - y);

			if (foundEntries.length || foundUploads.length) {
				const initUl = title => {
					const ul = document.createElement("ul");
					ul.setAttribute("data-title", title);
					return ul;
				};
				const ulEntries = foundEntries.map(x => makeItem(entries[x])).reduce((x, y) => {x.appendChild(y); return x;}, initUl("Blogs"));
				const ulUploads = foundUploads.map(x => makeItem(uploads[x])).reduce((x, y) => {x.appendChild(y); return x;}, initUl("Downloads"));
				popup.innerHTML = (foundEntries.length ? ulEntries.outerHTML : "") + (foundUploads.length ? ulUploads.outerHTML : "");
				overlay.setPosition(foundEntries.length ? ol.proj.fromLonLat(
					[0, 1].map(latLon => foundEntries.map(x => entries[x].pos[latLon]).reduce((x, y) => x + y, 0) / foundEntries.length)
				) : event.coordinate);
			} else {
				overlay.setPosition(undefined);
			}
		});
		map.on("pointermove", event => {
			const pixel = map.getEventPixel(event.originalEvent);
			const hit = map.hasFeatureAtPixel(pixel, {hitTolerance: 10});
			divMap.style.cursor = hit ? "pointer" : "";
		});
		map.on("rendercomplete", event => {
			const distance = uploads.map(u => u.length).reduce((a, b) => a + b, 0);
			document.querySelectorAll("span.distance-counter[data-category=\"" + data.category + "\"]").forEach(span => {
				span.innerHTML = (distance / 1000).toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0});
			});
		});
	});
});
