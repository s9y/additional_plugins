const timestampToColor = timestamp => {
	const date = new Date(timestamp * 1000);
	const minDate = new Date(date.getFullYear(), date.getMonth(), 1);
	const maxDate = new Date(date.getFullYear(), date.getMonth() + 1, 1);
	return "hsl(" + (360 * (date.getTime() - minDate.getTime()) / (maxDate.getTime() - minDate.getTime())).toFixed() + " 100% 50%)";
};

window.addEventListener("load", () => {
	document.querySelectorAll("div.map").forEach(divMap => {
		const popup = document.createElement("div");
		const overlay = new ol.Overlay({element: popup});
		popup.setAttribute("class", "ol-popup");
		popup.onclick = () => { overlay.setPosition(undefined); };

		const dataset = divMap.dataset;
		const articles = geo.articles
			.filter(article => ["all", "none"].includes(dataset.category) || article.categories.includes(parseInt(dataset.category)));
		const tracks = geo.tracks
			.filter(track => dataset.path.split("\n").some(y => track.url.startsWith(y)));
		const features = articles.map((article, id) => {
			const feature = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat(article.location.reverse())));
			feature.setId(id);
			feature.set("color", timestampToColor(article.date));
			return feature;
		});

		const osmSource = new ol.source.OSM();
		const layers = [
			new ol.layer.Tile({source: osmSource, preload: Infinity}),
			new ol.layer.Vector({
				source: new ol.source.Vector({features: features}),
				style: {
					"circle-radius": 6,
					"circle-fill-color": ["get", "color"],
					"circle-stroke-color": ["get", "color"]
				},
				zIndex: Infinity
			})
		];
		const unixTime = Date.now() / 1000;
		for (const track of tracks) {
			const source = new ol.source.Vector({
				url: track.url,
				format: new ol.format.GPX()
			});
			source.on("featuresloadend", event => {
				track.distance = event.features
					.filter(feature => feature.getGeometry().getType() === "MultiLineString")
					.map(feature => ol.sphere.getLength(feature.getGeometry()))
					.reduce((a, b) => a + b, 0);
			});
			const color = timestampToColor(track.date);
			const lineDash = track.date > unixTime ? [3, 6] : [0];
			const layer = new ol.layer.VectorImage({
				source: source,
				style: [{
					filter: ["==", ["geometry-type"], "LineString"],
					style: {
						"stroke-color": color,
						"stroke-width": 3,
						"stroke-line-dash": lineDash
					}
				}]
			});
			layers.push(layer);
		}
		const map = new ol.Map({
			controls: ol.control.defaults.defaults({rotate: false}).extend([
				new ol.control.FullScreen(),
				new ol.control.OverviewMap({
					layers: [new ol.layer.Tile({source: osmSource})]
				}),
				new ol.control.ScaleLine({bar: true, minWidth: 120})
			]),
			interactions: ol.interaction.defaults.defaults({altShiftDragRotate: false, pinchRotate: false}),
			layers: layers,
			overlays: [overlay],
			target: divMap,
			view: new ol.View({
				center: ol.proj.fromLonLat([dataset.longitude, dataset.latitude]),
				zoom: dataset.zoom
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
							new Date(object.date * 1000).toLocaleString(undefined, {
								year: "numeric",
								month: "long",
								day: "2-digit",
								hour: "2-digit",
								minute: "2-digit"
							})
							+
							(object.distance !== undefined
								? ", " + (object.distance / 1000).toLocaleString(undefined, {
									minimumFractionDigits: 2,
									maximumFractionDigits: 2
								}) + "km"
								: ""
							)
						);
						return a;
					})()
					: title
				)
				return li;
			};

			const foundArticles = [];
			const foundTracks = [];
			map.forEachFeatureAtPixel(event.pixel, (feature, layer) => {
				const id = feature.getId();
				if (id !== undefined) {
					foundArticles.push(id);
				} else {
					const url = layer.getSource().getUrl();
					const id = tracks.findIndex(track => track.url === url);
					foundTracks.push(id);
				}
			}, {hitTolerance: 10});
			foundArticles.sort();
			foundTracks.sort();

			if (foundArticles.length || foundTracks.length) {
				const initUl = title => {
					const ul = document.createElement("ul");
					ul.setAttribute("data-title", title);
					return ul;
				};
				const ulArticles = foundArticles
					.map(x => makeItem(articles[x]))
					.reduce((x, y) => { x.appendChild(y); return x; }, initUl("Articles"));
				const ulTracks = foundTracks
					.map(x => makeItem(tracks[x]))
					.reduce((x, y) => { x.appendChild(y); return x; }, initUl("Tracks"));
				popup.innerHTML = (foundArticles.length ? ulArticles.outerHTML : "") + (foundTracks.length ? ulTracks.outerHTML : "");
				overlay.setPosition(foundArticles.length ? ol.proj.fromLonLat(
					[0, 1].map(latLon => foundArticles
						.map(x => articles[x].location[latLon])
						.reduce((x, y) => x + y, 0) / foundArticles.length
					)
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
			const distance = tracks
				.filter(track => track.date < unixTime)
				.map(track => track.distance)
				.reduce((a, b) => a + b, 0);
			document.querySelectorAll("span.distance-counter[data-category=\"" + dataset.category + "\"]").forEach(span => {
				span.innerHTML = (distance / 1000).toFixed();
			});
		});
	});
});
