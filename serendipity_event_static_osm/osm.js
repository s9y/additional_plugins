const dateToColor = date => {
    const minDate = new Date(date.getFullYear(), date.getMonth() - 1, 0);
    const maxDate = new Date(date.getFullYear(), date.getMonth(), 0);
    return "hsl(" + ((date.getTime() - minDate.getTime()) / (maxDate.getTime() - minDate.getTime())) + "turn, 100%, 50%)"
};

window.onload = () => {
    const popup = document.getElementById("popup");
    popup.onclick = () => {
        overlay.setPosition(undefined);
    };

    const overlay = new ol.Overlay({
        element: popup
    });

    const features = [];
    for (const [id, entry] of Object.entries(geo.entries)) {
        const feature = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat(entry.pos.reverse())));
        feature.setId(id);
        features.push(feature);
    }

    const osmSource = new ol.source.OSM();
    const layers = [
        new ol.layer.Tile({source: osmSource}),
        new ol.layer.Vector({
            source: new ol.source.Vector({features: features}),
            style: feature => {
                const id = feature.getId();
                const entry = geo.entries[id];
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
    for (const upload of geo.uploads) {
        const layer = new ol.layer.Vector({
            source: new ol.source.Vector({
                url: upload.url,
                format: new ol.format.GPX()
            }),
            style: new ol.style.Style({
                stroke: new ol.style.Stroke({
                    color: dateToColor(new Date(upload.date * 1000)),
                    width: 3,
                    lineDash: upload.date * 1000 > Date.now() ? [3, 6] : undefined
                })
            })
        });
        layers.push(layer);
    }
    const data = document.getElementById("map").dataset;
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
        target: "map",
        view: new ol.View({
            center: ol.proj.fromLonLat([data.longitude, data.latitude]),
            zoom: data.zoom
        })
    });

    map.on("singleclick", event => {
        const makeItem = object => {
            const a = document.createElement("a");
            a.appendChild(document.createTextNode(object.title));
            a.setAttribute("href", object.url);
            a.setAttribute("title", (object.author !== undefined ? object.author + ", " : "") + new Date(object.date * 1000).toLocaleString(undefined, {year: "numeric", month: "long", day: "2-digit", hour: "2-digit", minute: "2-digit"}));
            const li = document.createElement("li");
            li.appendChild(a);
            return li;
        };

        const entries = [];
        const uploads = [];
        map.forEachFeatureAtPixel(event.pixel, (feature, layer) => {
            const id = feature.getId();
            if (id !== undefined) {
                entries.push(id);
            } else {
                const url = layer.getSource().getUrl();
                const id = geo.uploads.findIndex(upload => upload.url === url);
                uploads.push(id);
            }
        }, {hitTolerance: 10});
        entries.sort((x, y) => x - y);
        uploads.sort((x, y) => x - y);

        if (entries.length || uploads.length) {
            const initUl = title => {
                const ul = document.createElement("ul");
                ul.setAttribute("data-title", title);
                return ul;
            };
            const ulEntries = entries.map(x => makeItem(geo.entries[x])).reduce((x, y) => {x.appendChild(y); return x;}, initUl("Blogs"));
            const ulUploads = uploads.map(x => makeItem(geo.uploads[x])).reduce((x, y) => {x.appendChild(y); return x;}, initUl("Downloads"));
            popup.innerHTML = (entries.length ? ulEntries.outerHTML : '') + (uploads.length ? ulUploads.outerHTML : '');
            overlay.setPosition(entries.length ? ol.proj.fromLonLat(
                [0, 1].map(latLon => entries.map(x => geo.entries[x].pos[latLon]).reduce((x, y) => x + y, 0) / entries.length)
            ) : event.coordinate);
        } else {
            overlay.setPosition(undefined);
        }
    });
    map.on("pointermove", event => {
        const pixel = map.getEventPixel(event.originalEvent);
        const hit = map.hasFeatureAtPixel(pixel, {hitTolerance: 10});
        document.getElementById(map.getTarget()).style.cursor = hit ? "pointer" : "";
    });
};

