let createChart = {
    variables : {
        primaryColor    : 'rgb(0,46,91)',
        secondaryColor  : 'rgb(253,228,40)'
    },
    functions : {
        drawChart : ( canvas, debtID, type ) => {
            let debtLogValues = JSON.parse ( canvas.parentElement.parentElement.querySelector( 'input.debt-logs-json' ).value );
            let debtValues    = JSON.parse ( canvas.parentElement.parentElement.querySelector( 'input.current-debt-values' ).value );

            console.log( debtLogValues, debtValues );

            let data    = [];
            let options = [];
            switch ( type ) {
                case 'line' :
                    let labels = [],
                        values = [];
                    debtLogValues.forEach( ( log ) => {
                        let time = new Date( log.time );
                        labels.push( 'test' );
                        values.push( parseFloat( log.remaining ) );
                    } );
                    data =  {
                        labels: labels,
                            datasets: [{
                            label: debtValues.title,
                            backgroundColor: 'rgb(255,255,255)',
                            borderColor: createChart.variables.primaryColor,
                            data: values
                        }]
                    };
                    break;

                case 'pie' :
                    data =  {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                            label: debtValues.title,
                            backgroundColor: 'rgb(255, 99, 132)',
                            borderColor: 'rgb(255, 99, 132)',
                            data: [0, 10, 5, 2, 20, 30, 45]
                        }]
                    };
                    break;

                case 'doughnut' :
                    data =  {
                        labels: ['Remaining', 'Paid'],
                        datasets: [{
                            label: debtValues.title,
                            backgroundColor: [
                                createChart.variables.primaryColor,
                                createChart.variables.secondaryColor
                            ],
                            borderColor: [
                                'rgb(255,255,255)'
                            ],
                            data: [
                                debtValues.remaining,
                                debtValues.paid
                            ]
                        }]
                    };
                    options = {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: debtValues.title
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    };
                    break;
            }

            let ctx = canvas.getContext( '2d' );
            let chart = new Chart(ctx, {
                type: type,
                data: data,
                options: options
            });
        },
    },
};