let dcpExportHTML = {
    variables : {

    },
    functions : {
        pdfExport : ( form, canvas1, canvas2, canvas3, userID, url, meta ) => {
            let data1 = canvas1.toDataURL();
            let data2 = canvas2.toDataURL();
            let data3 = canvas3.toDataURL();


            jQuery.post(
                dcp_object.ajaxurl,
                {
                    action  : 'export_dcp_debt_pdf',
                    user_id : userID,
                    data1   : data1,
                    data2   : data2,
                    data3   : data3
                },
                function ( response ) {
                    url = url + '&meta=' + meta;
                    console.log( url );
                    location.href = url;
                }
            );
        }
    }
};
