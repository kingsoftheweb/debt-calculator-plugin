Chart.defaults.global.defaultFontSize = 18;

console.log( Chart );

let createChart = {
    variables : {
        primaryColor    : 'rgb(0,46,91)',
        secondaryColor  : 'rgb(253,228,40)',
        fontSize        : 16
    },
    functions : {
        drawChart : ( canvas, debtID, type, debtValuesJson = null, debtLogValuesArray = null, labels = null) => {
            let debtLogValues = [];
            let debtValues    = [];
            let chartLabels   = ( null !== labels ) ? labels : ['Remaining', 'Paid'];
            if( null !== debtValuesJson ) { // Total Debt Case.
                debtValues    = JSON.parse( debtValuesJson );
            } else {  // Single Debt Case.
                if( null !== debtLogValuesArray ) {
                    // Line Chart of debt logs per month.
                    debtLogValues = debtLogValuesArray.debt_logs;
                    debtValues    = debtLogValuesArray;
                } else {
                    // Line Chart for TOTAL Debt Logs
                    debtLogValues = JSON.parse ( canvas.parentElement.parentElement.querySelector( 'input.debt-logs-json' ).value );
                    debtValues    = JSON.parse ( canvas.parentElement.parentElement.querySelector( 'input.current-debt-values' ).value );
                }

            }

            let data    = [];
            let options = [];
            switch ( type ) {
                case 'line' :
                    let labels = [],
                        values = [];
                    debtLogValues.forEach( ( log ) => {
                        labels.push( log.time );
                        values.push( parseFloat( log.remaining ) );
                    } );
                    data =  {
                        labels: labels,
                        datasets: [{
                                label: debtValues.title,
                                backgroundColor: 'rgb(255,255,255)',
                                fontSize: createChart.variables.fontSize,
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
                        labels: chartLabels,
                        datasets: [{
                            label: debtValues.title,
                            backgroundColor: [
                                createChart.variables.primaryColor,
                                createChart.variables.secondaryColor
                            ],
                            fontSize: createChart.variables.fontSize,
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

        drawLineCombined : ( canvas, chartData = null, chartLabels = null ) => {
            let labels = [],
                values = [];
            chartData.forEach( ( log ) => {
                labels.push( log.year );
                values.push( parseFloat( log.total_paid ) );
            } );
            let data =  {
                labels: labels,
                datasets: [{
                    label: chartLabels.title,
                    backgroundColor: 'rgb(255,255,255)',
                    fontSize: 19,
                    borderColor: createChart.variables.primaryColor,
                    data: values
                }]
            };
            let options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            let ctx = canvas.getContext( '2d' );
            new Chart(ctx, {
                type: 'line',
                data: data,
                options: options
            });
        },
        drawDoughnutCombined : ( canvas, chartData = null, labels = null ) => {
           // console.log(chartData, labels);
            let dataLength = labels.length;
            let i=0;
            let r,g,b;
            let colors = [];
            for(i; i<dataLength; i++) {
                r = Math.floor(Math.random() * 255) + 0;
                g = Math.floor(Math.random() * 255) + 0;
                b = Math.floor(Math.random() * 255) + 0;
                colors.push( 'rgb(' + r + ',' + g + ',' + b + ')' );
            }
            //console.log( colors );
            let data =  {
                labels: labels,
                datasets: [{
                    label: '',
                    backgroundColor: colors,
                    fontSize: 19,
                    borderColor: [
                        'rgb(255,255,255)'
                    ],
                    data: chartData
                }]
            };
            let options = {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'All Payments'
                },
                animation: {
                    duration: 0
                },
            };

            let ctx = canvas.getContext( '2d' );
            new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: options
            });
        },
        drawLineChartPerYear : (  canvas, yearData, chartLabels  ) => {
            let chartData = yearData.data;
            let labels = [],
                values = [];
            chartData.forEach( ( month ) => {
                let monthPayments = parseFloat( month.payments );
                let monthPaymentsThousand = monthPayments/1000;
                labels.push( month.month );
                values.push( monthPaymentsThousand );
            } );
            let data =  {
                labels: labels,
                datasets: [{
                    label: chartLabels.title + ' Payments',
                    fontSize: 19,
                    backgroundColor: 'rgb(255,255,255)',
                    borderColor: createChart.variables.primaryColor,
                    data: values
                }]
            };
            let options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            let ctx = canvas.getContext( '2d' );
            new Chart(ctx, {
                type: 'line',
                data: data,
                options: options
            });
        }
    },


};