(function (window){
ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('salonmap', {
            center: [55.76, 37.64],
            zoom: 9
        }, {
            searchControlProvider: 'yandex#search'
        }),
        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: true
        });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set('preset', 'islands#nightDotIcon');
    objectManager.clusters.options.set('preset', 'islands#nightClusterIcons');
    myMap.geoObjects.add(objectManager);

    objectManager.add(datametki);

}

})(window);