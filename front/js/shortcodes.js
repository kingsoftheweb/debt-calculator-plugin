let dcmShortcodes = {

    debtCalculator: {
        elements: {
            singleTabs        : document.querySelectorAll('.single-grid-tab'),
            contentTabs       : document.querySelectorAll( '.arm_account_detail_tab.arm_account_detail_tab_content' ),
            resultsTabs       : document.querySelectorAll( 'td.arm-form-table-content.tab-has-result .title' ),
            totalDebtInfo     : document.querySelector( '.total-debts-chart__main' ),
            allDebtsInfo      : document.querySelector( '.total-debts-chart__main.all_debts' ),
            yearlyPaymentsDiv : document.querySelector( '.yearly-payments-chart__main' ),
            monthlyLogs       : document.querySelectorAll( '.multi-graphics-wrapper input.order_logs_per_month' ),
            addNewButton      : document.querySelector( '.dcm-shortcode input.submit.add-new-debt' ),
            updateButtons     : document.querySelectorAll( '.dcm-shortcode input.submit.update-debt' ),
            exportPDF         : document.querySelector( '.export-current-debt a.export-pdf' ),
        },
        events: () => {
            let plugin = dcmShortcodes.debtCalculator;

            // On load.
            window.onload = () => {
                plugin.functions.parseUrl();
                plugin.functions.reportsCharts();
            };

            // Single Tabs on Click.
            plugin.elements.singleTabs.forEach( ( tab ) => {
                tab.addEventListener('click', function () {
                    let id     = tab.getAttribute('data-id');
                    plugin.functions.showTab( id );
                    plugin.functions.updateUrl( id );


                });
            });

            // Tab Results on Click.
            plugin.elements.resultsTabs.forEach( ( tab ) => {
                tab.addEventListener( 'click', () => {
                    if( tab.parentElement.classList.contains( 'open' ) ) {
                        tab.parentElement.classList.remove( 'open' );
                    } else {
                        plugin.elements.resultsTabs.forEach( ( tab ) => { tab.parentElement.classList.remove( 'open' ) } );
                        tab.parentElement.classList.add( 'open' );
                    }

                } );
            } );


            // On Submit New Debt Button Click
            plugin.elements.addNewButton.addEventListener( 'click', function () {
                plugin.functions.addNewDebt( plugin.elements.addNewButton );
            } );

            // On Submit Update Debt Buttons Click
            plugin.elements.updateButtons.forEach( ( btn ) => {
               btn.addEventListener( 'click', function () {
                    plugin.functions.updateDebt( btn );
                } );
            } );

            // On PDF Export Button Click.
            plugin.elements.exportPDF.addEventListener( 'click', function () {
                let url     = plugin.elements.exportPDF.getAttribute( 'data-href' );
                let userID  = plugin.elements.exportPDF.getAttribute( 'data-userID' );
                let meta    = plugin.elements.exportPDF.getAttribute( 'data-meta' );
                //let html = document.querySelector( '.reports-graphics[data-id="' + btn.getAttribute( 'data-id' ) + '"]' ).innerHTML;
                let form    = plugin.elements.exportPDF.parentElement.querySelector( 'form' );
                let canvas1 = dcmShortcodes.debtCalculator.elements.totalDebtInfo.querySelector( 'canvas' );
                let canvas2 = dcmShortcodes.debtCalculator.elements.allDebtsInfo.querySelector( 'canvas' );
                let canvas3 = dcmShortcodes.debtCalculator.elements.yearlyPaymentsDiv.querySelector( 'canvas' );

                dcpExportHTML.functions.pdfExport( form, canvas1, canvas2, canvas3, userID, url, meta );
            } );

        },
        functions: {
            showTab : ( dataID ) => {
                dcmShortcodes.debtCalculator.elements.singleTabs.forEach( ( tab ) => {
                    tab.classList.remove( 'active' );
                } );
                document.querySelector( '.single-grid-tab[data-id="' + dataID + '"]' ).classList.add( 'active' );

                dcmShortcodes.debtCalculator.elements.contentTabs.forEach( ( tab ) => {
                    tab.classList.remove( 'active' );
                } );
                document.querySelector( '.arm_account_detail_tab.arm_account_detail_tab_content[data-tab="' + dataID + '"]' ).classList.add( 'active' );

                let targetBottom = parseInt ( document.querySelector( '.arm-tabs.dcm-wrapper.dcm-shortcode' ).offsetHeight )
                    + parseInt( document.querySelector( '.arm-tabs.dcm-wrapper.dcm-shortcode' ).offsetTop );

                window.scrollTo({
                    top: targetBottom,
                    left:0,
                    behavior: 'smooth'
                });
            },
            parseUrl : () => {
                let url     = new URL( location.href );
                let tab     =  url.searchParams.get( 'tab' );
                let debtID  = url.searchParams.get( 'debt_id' );
                if( null !== tab ) {
                    dcmShortcodes.debtCalculator.functions.showTab( tab );
                    return debtID;
                } else {
                    return null;
                }


            },
            updateUrl : ( tabID ) => {
                let locationUrl = new URL ( location.href );
                let userID = locationUrl.searchParams.get( 'user_id' );
                console.log( userID );
                // Check if user_id parameter exists.
                if( null !== userID ) {
                    let locationNew = '?user_id=' + userID + '&tab=' + tabID;
                    history.pushState(null, '', locationNew );
                    return locationNew;
                } else {
                    history.pushState(null, '', locationUrl.pathname + '?tab=' + tabID );
                    return locationUrl.pathname + '?tab=' + tabID;
                }

            },
            // Updating the Chart per each report for each debt.
            reportsCharts : () => {
                // Line Charts per each single debt.
                document.querySelectorAll( 'canvas.debts-reports.line-chart' ).forEach( ( canvas ) => {
                    //createChart.functions.drawChart( canvas, canvas.getAttribute( 'data-id' ), 'line' );
                } );

                // Line Charts for yearly payments.
                let yearlyPaymentValues = JSON.parse( dcmShortcodes.debtCalculator.elements.yearlyPaymentsDiv.querySelector( 'input[name=yearly_payments_values]' ).value );
                let yearlyPaymentsArray = [];
                yearlyPaymentValues.forEach( ( year ) => {
                    let totalPaidPerYear = 0;
                    year.debts.forEach( (debt) => {
                        totalPaidPerYear += parseFloat( debt.debt_values.total_paid );
                    } );
                    yearlyPaymentsArray.push( {
                        year : year.year,
                        total_paid : totalPaidPerYear
                    } );
                } );
                let yearlyPaymentCanvas = dcmShortcodes.debtCalculator.elements.yearlyPaymentsDiv.querySelector( 'canvas.yearly-payments-canvas' );
                let yearlyPaymentLabels = {
                    title: 'Yearly Payments'
                };
                createChart.functions.drawLineCombined( yearlyPaymentCanvas, yearlyPaymentsArray, yearlyPaymentLabels );


                // Doughnut Charts for total debts values.
                let totalDebtsValues = dcmShortcodes.debtCalculator.elements.totalDebtInfo.querySelector( 'input[name="total_debts_info"]' ).value;
                let totalDebtCanvas  = dcmShortcodes.debtCalculator.elements.totalDebtInfo.querySelector( 'canvas.total-debts-canvas' );
                createChart.functions.drawChart( totalDebtCanvas, totalDebtCanvas.getAttribute( 'data-id' ), 'doughnut', totalDebtsValues );

                let allDebtsInfoValues  = dcmShortcodes.debtCalculator.elements.allDebtsInfo.querySelector( 'input[name="total_debts_info"]' ).value;
                let allDebtsInfoLabels  = dcmShortcodes.debtCalculator.elements.allDebtsInfo.querySelector( 'input[name="total_debts_info_labels"]' ).value;
                let allDebtsInfoCanvas  = dcmShortcodes.debtCalculator.elements.allDebtsInfo.querySelector( 'canvas.total-debts-canvas' );
                createChart.functions.drawDoughnutCombined( allDebtsInfoCanvas,  JSON.parse( allDebtsInfoValues ), JSON.parse( allDebtsInfoLabels ) );



                // Doughnut and Line Charts for monthly logs per each debt
                dcmShortcodes.debtCalculator.elements.monthlyLogs.forEach( ( totalLogsInput ) => {
                    let totalLogsOrderedByMonth = JSON.parse( totalLogsInput.value );
                    console.log(totalLogsOrderedByMonth  );
                    let totalLogsOrderedByYear   = dcmShortcodes.debtCalculator.generalFunctions.converMonthLogsToYearLogs( totalLogsOrderedByMonth );

                    // Get first and last year
                    let firstYear = totalLogsOrderedByYear[0].year;
                    let lastYear  = totalLogsOrderedByYear[totalLogsOrderedByYear.length-1].year;

                    //console.log(firstYear, lastYear);
                    let allYearsData = [];
                    for( let i = firstYear; i <= lastYear; i++ ) {
                        // Get year logs of that year.
                        let logsPerYear = dcmShortcodes.debtCalculator.generalFunctions.getYearLogs( i, totalLogsOrderedByYear );
                        allYearsData.push( {
                            year: i,
                            data: logsPerYear
                        } );
                    }
                    console.log( allYearsData );

                    let debtID = totalLogsInput.getAttribute( 'data-id' );

                    totalLogsOrderedByMonth.forEach( ( month, index ) => {
                        let startDate =  month.start_date;
                        let endDate   =  month.end_date;

                        let beforeArrow = index === 0 ? '' : '<i class="fa fa-arrow-left arrow-direction"></i>';
                        let nextArrow   = index === totalLogsOrderedByMonth.length-1 ? '' : '<i class="fa fa-arrow-right arrow-direction"></i>';
                        let showClass   = index === totalLogsOrderedByMonth.length-1 ? 'show' : 'hide';


                        let singleMonth = document.createElement( 'div' );
                        singleMonth.classList.add( 'single-month-chart', showClass );
                        singleMonth.setAttribute( 'data-index', index );
                        singleMonth.insertAdjacentHTML( 'afterbegin',
                            '<div class="monthly-header" data-index = "' + index + '">' +
                                    '<span class="arrow" data-direction ="back" data-index = "' + index + '">' + beforeArrow +  '</span>'+
                                    '<span class="start-date">' + startDate +  '</span>'+
                                    '<span class="middle-icon">-</span>'+
                                    '<span class="end-date">' + endDate + '</span>'+
                                    '<span class="arrow" data-direction ="forward" data-index = "' + index + '">' + nextArrow +  '</span>'+
                                  '</div>' );
                        totalLogsInput.insertAdjacentElement( 'afterend', singleMonth );

                        // On Each Arrow Click
                        singleMonth.querySelectorAll( '.monthly-header .arrow i' ).forEach( ( arrow ) => {
                            arrow.addEventListener( 'click', () => {
                                console.log( arrow );
                                let currentIndex = arrow.parentElement.getAttribute( 'data-index' );
                                let nextIndex    = 0;
                                switch( arrow.parentElement.getAttribute( 'data-direction' ) ) {
                                    case 'forward' : nextIndex = parseInt( currentIndex ) + 1;
                                        break;
                                    case 'back' : nextIndex = parseInt( currentIndex ) - 1;
                                        break;
                                }
                              //  console.log( currentIndex, nextIndex );
                                document.querySelectorAll( '.single-month-chart' ).forEach( ( div ) => {
                                    div.classList.remove( 'show' );
                                } );
                                document.querySelector( '.single-month-chart[data-index="' + nextIndex + '"]' ).classList.add('show');
                            } );

                        } );

                        let doughnutChart = document.createElement( 'canvas' );
                        doughnutChart.classList.add( 'total-logs-per-month', 'line-chart' );
                        doughnutChart.setAttribute( 'debt-id', debtID );
                        doughnutChart.setAttribute( 'data-start_date', startDate );
                        doughnutChart.setAttribute( 'data-end_date', endDate );
                        singleMonth.insertAdjacentElement( 'beforeend', doughnutChart );
                        createChart.functions.drawChart( doughnutChart, debtID, 'doughnut', debtValuesJson = null, month );


                    } );


                    allYearsData.forEach( ( year ) => {
                        //console.log( year );
                        let lineCanvas = document.createElement( 'canvas' );
                        lineCanvas.classList.add( 'total-logs-per-month', 'line-chart' );
                        lineCanvas.setAttribute( 'debt-id', debtID );
                       // lineCanvas.setAttribute( 'data-start_date', startDate );
                        //lineCanvas.setAttribute( 'data-end_date', endDate );
                        document.querySelector( '.reports-graphics[data-id="'+ debtID + '"] .multi-graphics-wrapper' ).insertAdjacentElement( 'beforeend', lineCanvas );
                        createChart.functions.drawLineChartPerYear( lineCanvas, year, {title: year.year} );
                    } );


                } );

                // Doughnut Charts per each single debt.
                document.querySelectorAll( 'canvas.debts-reports.doughnut-chart' ).forEach( ( canvas ) => {
                    createChart.functions.drawChart( canvas, canvas.getAttribute( 'data-id' ), 'doughnut' );
                } );

            },
            addNewDebt : ( submitButton ) => {
                let authorID             = submitButton.parentElement.parentElement.parentElement.querySelector( 'input[name="author_id"]' ).value;
                let debtNameInput        = submitButton.parentElement.parentElement.parentElement.querySelector( 'input[name="debt_name"]' );
                let debtAmountInput      = submitButton.parentElement.parentElement.querySelector( 'input[name="debt_amount"]' );
                let yearlyInterestInput  = submitButton.parentElement.parentElement.querySelector( 'input[name="yearly_interest"]' );
                if(
                    '' === debtNameInput.value
                 || '' === debtAmountInput.value
                 || '' === yearlyInterestInput.value
                ) {
                    alert( 'Fill All Fields please.' );
                } else {
                    jQuery.post(
                        dcp_object.ajaxurl,
                        {
                            action          : 'add_dcp_debt',
                            debt_title      : debtNameInput.value,
                            debt_amount     : debtAmountInput.value,
                            yearly_interest : yearlyInterestInput.value,
                            author_id       : authorID
                        },
                        function ( response ) {
                            let newUrl = dcmShortcodes.debtCalculator.functions.updateUrl( 'debts-reports&debt_id=' + response );
                            location.href = newUrl;

                        }
                    );

                }
            },
            updateDebt : ( submitButton ) => {
                let debtID               = submitButton.parentElement.parentElement.querySelector( 'input[name="debt_id"]' ).value;
                let debtAmountInput      = submitButton.parentElement.parentElement.querySelector( 'input[name="pay_amount"]' );
                let remainingAmount      = submitButton.parentElement.parentElement.querySelector( 'input[name="remaining"]' ).value;
                let yearlyInterest       = submitButton.parentElement.parentElement.querySelector( 'input[name="interest"]' ).value;
                if( '' === debtAmountInput ) {
                    alert( 'Fill the Amount Field please.' );
                } else {
                    jQuery.post(
                        dcp_object.ajaxurl,
                        {
                            action      : 'update_dcp_debt',
                            debtID      : debtID,
                            paid        : debtAmountInput.value,
                            remaining   : remainingAmount,
                            interest    : yearlyInterest
                        },
                        function ( response ) {
                            let newUrl = dcmShortcodes.debtCalculator.functions.updateUrl( 'debts-reports&debt_id=' + response );
                            location.href = newUrl;
                        }
                    );

                }
            }
        },
        generalFunctions : {
            converMonthLogsToYearLogs : ( monthLogs ) => {
                let yearsLogs = [];
                monthLogs.forEach( ( month ) => {
                    let startDate = month.start_date.split('-');
                    startDate     = startDate[1] + '-' + startDate[0] + '-' + startDate[2];
                    let monthlyPaymentsTotal = 0;
                    month.debt_logs.forEach( ( log ) => {
                        monthlyPaymentsTotal += parseFloat( log.paid );
                    } );
                    yearsLogs.push({
                        paymentsTotal  : monthlyPaymentsTotal,
                        month          : new Date( startDate ).getMonth()+1,
                        year           : new Date( startDate ).getFullYear(),
                        title          : month.title
                    });
                } );
                return yearsLogs;
            },
            getYearLogs : ( year, yearsLogs ) => {
                let yearArray = [];
                let months = [
                    [1, 'Jan'],
                    [2, 'Feb'],
                    [3, 'Mar'],
                    [4, 'Apr'],
                    [5, 'May'],
                    [6, 'Jun'],
                    [7, 'Jul'],
                    [8, 'Aug'],
                    [9, 'Sep'],
                    [10, 'Oct'],
                    [11, 'Nov'],
                    [12, 'Dec'],
                ];
                months.forEach( (month) => {
                    let monthIndex = month[0];
                    let monthName  = month[1];

                    // Get the payments of this months ( if it does not have any payments, it will be zero)
                    let totalPayments = 0;
                    let debtTitle = '';
                    yearsLogs.forEach( ( monthYear ) => {
                        if (
                               monthYear.year === year
                            && monthYear.month === monthIndex
                        ) {
                            totalPayments = monthYear.paymentsTotal;
                            debtTitle     = monthYear.title;
                        }
                    });

                    yearArray.push({
                        'month'    : monthName,
                        'index'    : monthIndex,
                        'payments' : totalPayments,
                        'title'    : debtTitle
                    });
                } );

                return yearArray;
            }
        },
        init: () => {
            dcmShortcodes.debtCalculator.events();
        }
    }

};

window.addEventListener('DOMContentLoaded', (event) => {
    dcmShortcodes.debtCalculator.init();
});

/*
var rangeSlider = function(){
    var slider = jQuery('.row'),
        range = jQuery('.value_range'),
        value = jQuery('.field-text');

    slider.each(function(){

        value.each(function(){
            var value = jQuery(this).prev().attr('value');
            jQuery(this).html(value);
        });

        range.on('input', function(){
            jQuery(this).next(value).html(this.value);
        });
    });
};
rangeSlider();

jQuery('#submit').click(function(){
    var h = jQuery('#height').val() / 100;
    var w = jQuery('#weight').val();
    var bmi = h * h ;
    bmi = w/bmi;
    bmi = (bmi).toFixed(1);
    jQuery('#bmiValue').html(bmi + " ");
    if (bmi < 18.5) {
        //Underweight
        jQuery('.result-text').css('background','-webkit-linear-gradient(left top, #27939D, #07658F)');
        jQuery('.result-text').css('background','-o-linear-gradient(bottom right, #27939D, #07658F)');
        jQuery('.result-text').css('background','-moz-linear-gradient(bottom right, #27939D, #07658F)');
        jQuery('.result-text').css('background','linear-gradient(to bottom right, #27939D, #07658F)');
        jQuery('#bmid').html("Underweight");
    } else if ((18.5 <= bmi) && (bmi <= 24.9)) {
        //Normal weight
        jQuery('.result-text').css('background','-webkit-linear-gradient(left top, #4FD24D, #4CA456)');
        jQuery('.result-text').css('background','-o-linear-gradient(bottom right, #4FD24D, #4CA456)');
        jQuery('.result-text').css('background','-moz-linear-gradient(bottom right, #4FD24D, #4CA456)');
        jQuery('.result-text').css('background','linear-gradient(to bottom right, #4FD24D, #4CA456)');
        jQuery('#bmid').html("Normal");
    } else if ((25 <= bmi) && (bmi <= 29.9)) {
        //Overweight
        jQuery('.result-text').css('background','-webkit-linear-gradient(left top, #EF7532, #DC3A26)');
        jQuery('.result-text').css('background','-o-linear-gradient(bottom right, #EF7532, #DC3A26)');
        jQuery('.result-text').css('background','-moz-linear-gradient(bottom right, #EF7532, #DC3A26)');
        jQuery('.result-text').css('background','linear-gradient(to bottom right, #EF7532, #DC3A26)');
        jQuery('#bmid').html("Overweight");
    } else {
        //Obese
        jQuery('.result-text').css('background','-webkit-linear-gradient(left top, #F73946, #FF3875)');
        jQuery('.result-text').css('background','-o-linear-gradient(bottom right, #F73946, #FF3875)');
        jQuery('.result-text').css('background','-moz-linear-gradient(bottom right, #F73946, #FF3875)');
        jQuery('.result-text').css('background','linear-gradient(to bottom right, #F73946, #FF3875)');
        jQuery('#bmid').html("Obese");
    }
    console.log(bmi);
});

jQuery('input[type="range"]').change(function () {
    var val = (jQuery(this).val() - jQuery(this).attr('min')) / (jQuery(this).attr('max') - jQuery(this).attr('min'));

    jQuery(this).css('background-image',
        '-webkit-gradient(linear, left top, right top, '
        + 'color-stop(' + val + ', #F73946), '
        + 'color-stop(' + val + ', #27283A)'
        + ')'
    );
});

jQuery('.value_range').each(function (){
    var val = (jQuery(this).val() - jQuery(this).attr('min')) / (jQuery(this).attr('max') - jQuery(this).attr('min'));

    jQuery(this).css('background-image',
        '-webkit-gradient(linear, left top, right top, '
        + 'color-stop(' + val + ', #F73946), '
        + 'color-stop(' + val + ', #27283A)'
        + ')'
    );
})*/
;