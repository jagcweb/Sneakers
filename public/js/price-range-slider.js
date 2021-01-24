var elem = document.querySelector('.py-4');
if (elem.clientWidth > 1440) {

    var mySlider = new rSlider({
        target: '#sampleSlider',
        values: {min: 0, max: 500},
        range: true,
        tooltip: true,
        scale: false,
        labels: false,
        step: 20,
        width: 220,
        set: [20, 50],
        onChange: function (values) {
            var split = values.split(",", 2);
            var start = document.querySelector('.start');
            var end = document.querySelector('.end');

            start.value = split[0];
            end.value = split[1];
        }
    });


    mySlider.onChange(function (values) {
        console.log(values);
    });


} else if (elem.clientWidth <= 1440 && elem.clientWidth >= 1280) {
    var mySlider = new rSlider({
        target: '#sampleSlider',
        values: {min: 0, max: 500},
        range: true,
        tooltip: true,
        scale: false,
        labels: false,
        step: 20,
        width: 150,
        set: [20, 50],
        onChange: function (values) {
            var split = values.split(",", 2);
            var start = document.querySelector('.start');
            var end = document.querySelector('.end');

            start.value = split[0];
            end.value = split[1];
        }
    });


    mySlider.onChange(function (values) {
        console.log(values);
    });

}else if (elem.clientWidth < 1280 && elem.clientWidth > 900) {
    var mySlider = new rSlider({
        target: '#sampleSlider',
        values: {min: 0, max: 500},
        range: true,
        tooltip: true,
        scale: false,
        labels: false,
        step: 20,
        width: 130,
        set: [20, 50],
        onChange: function (values) {
            var split = values.split(",", 2);
            var start = document.querySelector('.start');
            var end = document.querySelector('.end');

            start.value = split[0];
            end.value = split[1];
        }
    });


    mySlider.onChange(function (values) {
        console.log(values);
    });

}else if (elem.clientWidth <= 900) {
    var mySlider = new rSlider({
        target: '#sampleSlider',
        values: {min: 0, max: 500},
        range: true,
        tooltip: true,
        scale: false,
        labels: false,
        step: 20,
        width: 110,
        set: [20, 50],
        onChange: function (values) {
            var split = values.split(",", 2);
            var start = document.querySelector('.start');
            var end = document.querySelector('.end');

            start.value = split[0];
            end.value = split[1];
        }
    });


    mySlider.onChange(function (values) {
        console.log(values);
    });

}
