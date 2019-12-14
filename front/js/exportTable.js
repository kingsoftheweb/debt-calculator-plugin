let dcpExportHTML = {
    variables : {

    },
    functions : {
        pdfExport : ( canvas1, canvas2, canvas3, canvas4, userID, url, meta ) => {
            let data1 = canvas1.toDataURL();
            let data2 = canvas2.toDataURL();
            let data3 = canvas3.toDataURL();
            let data4 = canvas4.toDataURL();


            jQuery.post(
                dcp_object.ajaxurl,
                {
                    action  : 'export_dcp_debt_pdf',
                    user_id : userID,
                    data1   : data1,
                    data2   : data2,
                    data3   : data3,
                    data4   : data4
                },
                function ( response ) {
                    url = url + '&meta=' + meta;
                    console.log( url );
                    window.open(url,'pdfDownload','width=1200,height=1697');
                    location.href = url;
                }
            );
        }
    }
};
