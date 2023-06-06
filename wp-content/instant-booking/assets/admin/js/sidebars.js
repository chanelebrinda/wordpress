/***********************************pdf active ************************ */
(function ($) {
  "use strict";
 
     $('a.media').media({width:630, height:950});
      
  
 })(jQuery); 
 
 /***********************************MORRIS active ************************ */
 
 
   
 Morris.Area({
   element: 'extra-area-chart',
   data: [{
     period: '2010',
     CSE: 50,
     Accounting: 80,
     Electrical: 20
   }, {
     period: '2011',
     CSE: 130,
     Accounting: 100,
     Electrical: 80
   }, {
     period: '2012',
     CSE: 80,
     Accounting: 60,
     Electrical: 70
   }, {
     period: '2013',
     CSE: 70,
     Accounting: 200,
     Electrical: 140
   }, {
     period: '2014',
     CSE: 180,
     Accounting: 150,
     Electrical: 140
   }, {
     period: '2015',
     CSE: 105,
     Accounting: 100,
     Electrical: 80
   },
    {
     period: '2016',
     CSE: 250,
     Accounting: 150,
     Electrical: 200
   }],
   xkey: 'period',
   ykeys: ['CSE', 'Accounting', 'Electrical'],
   labels: ['CSE', 'Accounting', 'Electrical'],
   pointSize: 3,
   fillOpacity: 0,
   pointStrokeColors:['#006DF0', '#933EC5', '#65b12d'],
   behaveLikeLine: true,
   gridLineColor: '#e0e0e0',
   lineWidth: 1,
   hideHover: 'auto',
   lineColors: ['#006DF0', '#933EC5', '#65b12d'],
   resize: true
   
 });
 
 /***********************************FULLCALENDAR active ************************ */
 
 $(function() {
 
   var todayDate = moment().startOf('day');
   var YM = todayDate.format('YYYY-MM');
   var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
   var TODAY = todayDate.format('YYYY-MM-DD');
   var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
 
   $('#calendar').fullCalendar({
     header: {
       left: 'prev,next today',
       center: 'title',
       right: 'month,agendaWeek,agendaDay,listWeek'
     },
     editable: true,
     eventLimit: true, // allow "more" link when too many events
     navLinks: true,
     backgroundColor: '#1f2e86',   
     eventTextColor: '#1f2e86',
     textColor: '#378006',
     dayClick: function(date, jsEvent, view) {
 
         alert('Clicked on: ' + date.format());
 
         alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
 
         alert('Current view: ' + view.name);
 
         // change the day's background color just for fun
         $(this).css('background-color', 'red');
 
     },
     events: [
       {
         title: 'All Day Event',
         start: YM + '-01',
         color: '#006DF0'
       },
       {
         title: 'Long Event',
         start: YM + '-07',
         end: YM + '-10',
         color: '#933EC5'
       },
       {
         id: 999,
         title: 'Repeating Event',
         start: YM + '-09T16:00:00',
         color: '#65b12d'
       },
       {
         id: 999,
         title: 'Repeating Event',
         start: YM + '-16T16:00:00',
         color: '#D80027'
       },
       {
         title: 'Conference',
         start: YESTERDAY,
         end: TOMORROW,
         color: '#f3c30b'
       },
       {
         title: 'Meeting',
         start: TODAY + 'T10:30:00',
         end: TODAY + 'T12:30:00',
         color: '#1f2e86'
       },
       {
         title: 'Lunch',
         start: TODAY + 'T12:00:00',
         color: '#0D4CFF'
       },
       {
         title: 'Meeting',
         start: TODAY + 'T14:30:00',
         color: '#1f2e86'
       },
       {
         title: 'Happy Hour',
         start: TODAY + 'T17:30:00',
         color: '#AA00FF'
       },
       {
         title: 'Dinner',
         start: TODAY + 'T20:00:00',
         color: '#00BCD4'
       },
       {
         title: 'Birthday Party',
         start: TOMORROW + 'T07:00:00',
         color: '#FF5722'
       },
       {
         title: 'Click for Google',
         url: 'http://google.com/',
         start: YM + '-28',
         color: '#323232'
       }
     ]
   });
 });

/* global bootstrap: false */
(function () {
  'use strict'
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl)
  })
})()
