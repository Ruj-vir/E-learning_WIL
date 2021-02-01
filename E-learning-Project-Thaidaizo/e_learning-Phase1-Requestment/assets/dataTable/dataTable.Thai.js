/**
 * Thai translation
 *  @name Thai
 *  @anchor Thai
 */

	$.extend(true, $.fn.dataTable.defaults, {
		"language": {
				  "sProcessing": "กำลังดำเนินการ...",
				  "sLengthMenu": "แสดง _MENU_ แถว",
				  "sZeroRecords": "ไม่พบข้อมูล",
				  "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
				  "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
				  "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
				  "sInfoPostFix": "",
				  "sSearch": "ค้นหา:",
				  "sUrl": "",
				  "oPaginate": {
								"sFirst": "เริ่มต้น",
								"sPrevious": "ก่อนหน้า",
								"sNext": "ถัดไป",
								"sLast": "สุดท้าย"
				  }
		 }
	});

	$('.table').DataTable();