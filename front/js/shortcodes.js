let dcmShortcodes = {

    debtCalculator: {
        elements: {
            singleTabs: document.querySelectorAll('.single-tab'),
        },
        events: () => {
            let plugin = dcmShortcodes.debtCalculator;

            // Single Tabs on Click.
            plugin.elements.singleTabs.forEach((tab) => {
                tab.addEventListener('click', function () {
                    let id = tab.getAttribute('data-id');
                    jQuery('.single-tab').removeClass('active');
                    tab.classList.add('active');

                    jQuery('.arm_account_detail_tab.arm_account_detail_tab_content').removeClass('active');
                    jQuery('.arm_account_detail_tab.arm_account_detail_tab_content[data-tab="' + id + '"]').addClass('active');
                });
            });
        },
        functions: {},
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