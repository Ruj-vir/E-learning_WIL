<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>



<div class="container-fluid">
    <div class="row">

        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card my-4">
                <div class="card-header text-uppercase">
                    <i class="far fa-calendar-alt"></i> Course Calendar
                </div>
                <div class="card-body">

                <div id="calendar_list"></div>

                </div>
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->

<?php include "templates/footer.php"; ?>

  <link href='assets/fullcalendar/core/main.min.css' rel='stylesheet' />
  <link href='assets/fullcalendar/daygrid/main.min.css' rel='stylesheet' />
  <link href='assets/fullcalendar/list/main.min.css' rel='stylesheet' />

  <script src='assets/fullcalendar/core/main.min.js'></script>
  <script src='assets/fullcalendar/daygrid/main.min.js'></script>
  <script src='assets/fullcalendar/list/main.min.js'></script>
  <script src='assets/fullcalendar/interaction/main.min.js'></script>

  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar_list');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid' , 'list' ],
      plugins: [ 'interaction', 'dayGrid', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,listMonth'
      },
      //defaultDate: '2020-02-12',
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: false,
      weekNumbers: true,
      eventLimit: true, // allow "more" link when too many events
      events: 'return/return_course_calendar.php',
      eventTimeFormat: { // 24 hour
        hour: '2-digit',
        minute: '2-digit',
        //second: '2-digit',
        hour12: false
      }
    });
    calendar.render();
  });

</script>