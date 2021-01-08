


	   var table = $('#CanteenConfirm').DataTable({

	'columnDefs': [{
	'targets': 0,
	'searchable':false,
	'orderable':false,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
	      }],
    //"lengthMenu": [[5, 10, 20, -1], [5, 10, 50, "All"]],
	'order': [1, 'asc'],
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    dom: 'Bfrt<"col-md-6 inline btn-leng"i> <"col-md-6 inline"p>',
		  
      buttons: [
      {
        extend: 'copyHtml5',
        footer: 'true',
        text: '<i class="fa fa-clipboard"></i> Copy',
        title: 'Confirm canteen TDA',
        titleAttr: 'Copy',
        className: 'btn btn-app export Copy',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] } },
     /* {
        extend: 'pdfHtml5',
        footer: 'true',
        text: '<i class="fa fa-file-pdf-o"></i> PDF',
        title: 'Confirm canteen TDA',
        titleAttr: 'PDF',
        className: 'btn btn-app export pdf',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] },

        customize: function (doc) {

          doc.styles.title = {
            color: '#8eb852',
            fontSize: '30',
            alignment: 'center' };

          doc.styles['td:nth-child(2)'] = {
            width: '100px',
            'max-width': '100px' },

          doc.styles.tableHeader = {
            fillColor: '#8eb852',
            color: 'white',
            alignment: 'center' },

          doc.content[1].margin = [100, 0, 100, 0];

        } },*/

      {
        extend: 'excelHtml5',
        footer: 'true',
        text: '<i class="fas fa-file-excel"></i> Excel',
        title: 'Confirm canteen TDA',
        titleAttr: 'Excel',
        className: 'btn btn-app export excel',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] } },
      {
        extend: 'csvHtml5',
        footer: 'true',
        text: '<i class="fas fa-file-csv"></i> CSV',
        title: 'Confirm canteen TDA',
        titleAttr: 'CSV',
        className: 'btn btn-app export csv',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] } },
      {
        extend: 'print',
        footer: 'true',
        text: '<i class="fa fa-print"></i> Print',
        title: 'Confirm canteen TDA',
        titleAttr: 'Print',
        className: 'btn btn-app export Print',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] } },
      {
        extend: 'pageLength',
        titleAttr: 'Registros a mostrar',
        className: 'selectTable' }] ,
		  

        "footerCallback": function ( row, data, start, end, display ) {
            var api1 = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api1
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api1
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api1.column( 5 ).footer() ).html(
                ''+pageTotal +'.00'
            );
        }
	});
table.buttons().container().appendTo($('#printbar'));