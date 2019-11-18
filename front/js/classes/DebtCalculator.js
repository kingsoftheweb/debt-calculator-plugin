class DebtCalculator extends DCMShortcodes {

    constructor() {
        super();
        this.elements = {
            singleTabs    : document.querySelectorAll('.single-grid-tab'),
            contentTabs   : document.querySelectorAll( '.arm_account_detail_tab.arm_account_detail_tab_content' ),
            resultsTabs   : document.querySelectorAll( 'td.arm-form-table-content.tab-has-result .title' ),
            debtInfoMonth : document.querySelectorAll( 'total-debts-chart .total-debts-chart__main' ),
            addNewButton  : document.querySelector( '.dcm-shortcode input.submit.add-new-debt' ),
            updateButtons : document.querySelectorAll( '.dcm-shortcode input.submit.update-debt' ),
            exportPDFs    : document.querySelectorAll( '.results-tab a.export-pdf' ),
        };
        this.functions = this.getFunctions();
        this.events();
    }

    events () {
        let debtCalc = this;
        // On load.
        window.onload = () => {
            this.functions.parseUrl();
            //this.functions.reportsCharts();
        };

        // Single Tabs on Click.
        this.elements.singleTabs.forEach( ( tab ) => {

            tab.addEventListener('click', function () {
                let id     = tab.getAttribute('data-id');
                console.log(debtCalc);
                debtCalc.functions.showTab( id );
                debtCalc.functions.updateUrl( id );
            });
        });

        // Tab Results on Click.
        this.elements.resultsTabs.forEach( ( tab ) => {
            tab.addEventListener( 'click', () => {
                if( tab.parentElement.classList.contains( 'open' ) ) {
                    tab.parentElement.classList.remove( 'open' );
                } else {
                    debtCalc.elements.resultsTabs.forEach( ( tab ) => { tab.parentElement.classList.remove( 'open' ) } );
                    tab.parentElement.classList.add( 'open' );
                }

            } );
        } );

        // On Submit New Debt Button Click
        this.elements.addNewButton.addEventListener( 'click', function () {
            debtCalc.functions.addNewDebt( debtCalc.elements.addNewButton );
        } );

        // On Submit Update Debt Buttons Click
        this.elements.updateButtons.forEach( ( btn ) => {
            btn.addEventListener( 'click', function () {
                debtCalc.functions.updateDebt( btn );
            } );
        } );


        // On Export Button Click.
        this.elements.exportPDFs.forEach( ( btn ) => {
            btn.addEventListener( 'click', function () {
                let url  = btn.getAttribute( 'data-href' );
                let html = document.querySelector( '.reports-graphics[data-id="' + btn.getAttribute( 'data-id' ) + '"]' ).innerHTML;
                dcpExportHTML.functions.pdfExport( html, url );
            } );
        } );
    }
    
    getFunctions () {
        return {
            showTab : ( dataID ) => {
                this.elements.singleTabs.forEach( ( tab ) => {
                    tab.classList.remove( 'active' );
                } );
                document.querySelector( '.single-grid-tab[data-id="' + dataID + '"]' ).classList.add( 'active' );

               this.elements.contentTabs.forEach( ( tab ) => {
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
                   this.functions.showTab( tab );
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
            reportsCharts : () => {
                // Line Charts per each single debt.
                document.querySelectorAll( 'canvas.debts-reports.line-chart' ).forEach( ( canvas ) => {
                    createChart.functions.drawChart( canvas, canvas.getAttribute( 'data-id' ), 'line' );
                } );

                // Doughnut Charts for total debts values.
                /*let totalDebtsValues = this.elements.totalDebtInfo.querySelector( 'input[name=]' ).value;
                this.elements.totalDebtInfo.forEach( ( canvas ) => {
                    createChart.functions.drawChart( canvas, canvas.getAttribute( 'data-id' ), 'doughnut' );
                } );
*/
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
                            let newUrl =this.functions.updateUrl( 'debts-reports&debt_id=' + response );
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
                            let newUrl =this.functions.updateUrl( 'debts-reports&debt_id=' + response );
                            location.href = newUrl;
                        }
                    );

                }
            }
        };
    }

}

window.addEventListener('DOMContentLoaded', (event) => {
    let debtCalculator = new DebtCalculator();
});