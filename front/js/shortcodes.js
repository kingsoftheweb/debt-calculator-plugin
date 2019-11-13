let dcmShortcodes = {

    debtCalculator: {
        elements: {
            singleTabs   : document.querySelectorAll('.single-grid-tab'),
            contentTabs  : document.querySelectorAll( '.arm_account_detail_tab.arm_account_detail_tab_content' ),
            resultsTabs  : document.querySelectorAll( 'td.arm-form-table-content.tab-has-result .title' ),
            submitButton : document.querySelector( '.debt-calculator input.submit' )
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
            plugin.elements.submitButton.addEventListener( 'click', function () {
                plugin.functions.addNewDebt( plugin.elements.submitButton );
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
                history.pushState(null, '', locationUrl.pathname + '?tab=' + tabID );
                return locationUrl.pathname + '?tab=' + tabID;
            },
            // Updating the Chart per each report for each debt.
            reportsCharts : () => {
                // Line Charts.
                document.querySelectorAll( 'canvas.debts-reports.line-chart' ).forEach( ( canvas ) => {
                    createChart.functions.drawChart( canvas, canvas.getAttribute( 'data-id' ), 'line' );
                } );

                // Pie Charts.
                document.querySelectorAll( 'canvas.debts-reports.pie-chart' ).forEach( ( canvas ) => {
                    createChart.functions.drawChart( canvas, canvas.getAttribute( 'data-id' ), 'pie' );
                } );

                // Doughnut Charts.
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