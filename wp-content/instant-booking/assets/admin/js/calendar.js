
 
 /***********************************FULLCALENDAR active ************************ */

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('fs-calendar');
   
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next ,today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listMonth'
      },
      initialDate: new Date(),
      navLinks: true, // can click day/week names to navigate views
      //businessHours: true, // display business hours
     // editable: true,
      selectable: true,
      locale: 'fr',
     // timeFormat : 'h:mm tt',
      defaultView: 'dayGridMonth',
      allDayText: 'all-jours',
      buttonText:{
        today:'Aujourd\'hui',
        month: 'Mois',
        week: 'Semaine',
        day: 'Jour',
        list: 'liste'
      },
      events: 
        {
           url: calendarajax.ajaxurl,
          // method: 'POST',
          extraParams: {
            action: 'ajaxselect_all',
          },
          error: function() {
           alert('echec')
          },
          color: '#53d56c',   // a non-ajax option
          textColor: '#fff', // a non-ajax option
          backgroundColor: '#f0d56c',
          borderColor: '#53d56c',
         // display: 'block',
          // borderColor: '',
          // borderColor: '',
        },
 
    }); 
    setTimeout(() => {
      
      var f =calendar.render();
      f.fadeIn();
    }, 2500);
    
});