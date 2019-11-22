let createChart = {
    variables : {
        primaryColor    : 'rgb(0,46,91)',
        secondaryColor  : 'rgb(253,228,40)'
    },
    functions : {
        drawChart : ( canvas, debtID, type, debtValuesJson = null ) => {
            let debtLogValues = [];
            let debtValues    = [];
            if( null !== debtValuesJson ) { // Total Debt Case.
                debtValues    = JSON.parse( debtValuesJson );
            } else {  // Single Debt Case.
                debtLogValues = JSON.parse ( canvas.parentElement.parentElement.querySelector( 'input.debt-logs-json' ).value );
                debtValues    = JSON.parse ( canvas.parentElement.parentElement.querySelector( 'input.current-debt-values' ).value );
            }

            console.log( debtValues );

            let data    = [];
            let options = [];
            switch ( type ) {
                case 'line' :
                    let labels = [],
                        values = [];
                    debtLogValues.forEach( ( log ) => {
                        let time = new Date( log.time );
                        labels.push( log.time );
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
                    options = {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
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
                                debtValues.total_paid
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
                            duration: 0
                        },
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