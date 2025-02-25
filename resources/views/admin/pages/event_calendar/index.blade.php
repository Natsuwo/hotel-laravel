@extends('admin.layouts.master')
@section('content')
    <div id="calendar"></div>
    <!-- Create Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Create / Edit Event</h5>
                    <button type="button" id='deleteEventButton' class="btn btn-danger">
                        <i class="fa fa-trash" style="width:100%; text-align: center;"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="eventForm" onsubmit="return false;">
                        <div class="form-group">
                            <label for="eventTitle">Title</label>
                            <input type="text" class="form-control" id="eventTitle" name="title" required>
                        </div>
                        <input type="hidden" name="id" id="eventId" value="">
                        <div class="form-group">
                            <label for="eventColor">Color</label>
                            <select class="form-control" id="eventColor" name="color" required>
                                <option value="#dc3545">Danger</option>
                                <option value="#28a745">Success</option>
                                <option value="#007bff">Primary</option>
                                <option value="#ffc107">Warning</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="eventStartDate">Start Date</label>
                            <input type="datetime-local" class="form-control" id="eventStartDate" name="start" required>
                        </div>
                        <div class="form-group">
                            <label for="eventEndDate">End Date</label>
                            <input type="datetime-local" class="form-control" id="eventEndDate" name="end" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="addEventButton">Add Event</button>
                    <script>
                        document.getElementById('eventForm').addEventListener('keypress', function(event) {
                            if (event.key === 'Enter') {
                                event.preventDefault();
                                document.getElementById('addEventButton').click();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('my-script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
    <style>
        #calendar {
            margin: 40px auto;
            margin-left: 40px;
            margin-right: 40px;
        }

        a.fc-event.fc-daygrid-event[href] {
            color: #17a2b8;
            /* Bootstrap info color */
        }

        a.fc-event.fc-daygrid-event[href]:visited {
            color: #6610f2;
            /* Bootstrap purple color */
        }

        .fc .fc-daygrid-day.fc-day-other {
            background: var(--fc-neutral-bg-color);
        }

        .fc .fc-scrollgrid-section-sticky>* {
            background: unset;
            position: sticky;
            z-index: 3;
        }

        :not(td[aria-labelledby])>.fc-daygrid-day-frame {
            background: var(--fc-neutral-bg-color);
        }

        .fc .fc-scrollgrid-section-body {
            background: var(--fc-page-bg-color);
        }

        .fc .fc-timegrid-slot-label,
        .fc .fc-timegrid-axis-frame {
            background-color: var(--main-page-bg-color);
        }

        :root {
            --main-page-bg-color: #38425e;
            --fc-small-font-size: .85em;
            --fc-page-bg-color: #38425e;
            --fc-neutral-bg-color: #38425e;
            --fc-neutral-text-color: #f8f9fa;
            --fc-border-color: #dee2e6;

            --fc-button-text-color: #fff;
            --fc-button-bg-color: #007bff;
            --fc-button-border-color: #007bff;
            --fc-button-hover-bg-color: #0056b3;
            --fc-button-hover-border-color: #004085;
            --fc-button-active-bg-color: #004085;
            --fc-button-active-border-color: #003366;

            --fc-event-bg-color: #007bff;
            --fc-event-border-color: #007bff;
            --fc-event-text-color: #fff;
            --fc-event-selected-overlay-color: rgba(0, 0, 0, 0.25);

            --fc-more-link-bg-color: #d0d0d0;
            --fc-more-link-text-color: inherit;

            --fc-event-resizer-thickness: 8px;
            --fc-event-resizer-dot-total-width: 8px;
            --fc-event-resizer-dot-border-width: 1px;

            --fc-non-business-color: rgba(215, 215, 215, 0.3);
            --fc-bg-event-color: rgb(143, 223, 130);
            --fc-bg-event-opacity: 0.3;
            --fc-highlight-color: rgba(188, 232, 241, 0.3);
            --fc-today-bg-color: #007bff25;
            --fc-now-indicator-color: red;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        $(document).ready(function() {
            async function addNewEvent(event) {
                return $.ajax({
                    url: "{{ route('admin.event_calendar.store') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        title: event.title,
                        start: event.start,
                        end: event.end,
                        color: event.color
                    },
                    success: function(response) {
                        if (response) {
                            return response;
                        }
                    },
                    error: function() {
                        alert('Failed to create event.');
                    }
                });
            }

            function toISOLocal(d) {
                const z = n => ('0' + n).slice(-2);
                return d.getFullYear() + '-' +
                    z(d.getMonth() + 1) + '-' +
                    z(d.getDate()) + 'T' +
                    z(d.getHours()) + ':' +
                    z(d.getMinutes());
            }

            $('#deleteEventButton').on('click', function() {
                if (confirm('Are you sure you want to delete this event?')) {
                    const id = $('#eventId').val();
                    if (id) {
                        $.ajax({
                            url: "{{ route('admin.event_calendar.destroy', ['event_calendar' => 1]) }}",
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            success: function(response) {
                                if (response) {
                                    calendar.getEventById(id).remove();
                                    $('#eventModal').modal('hide');
                                    $('#eventForm')[0].reset();
                                }
                            },
                            error: function() {
                                alert('Failed to delete event.');
                            }
                        });
                    }
                }
            });

            async function editEvent(event) {
                return $.ajax({
                    url: "{{ route('admin.event_calendar.update', ['event_calendar' => 1]) }}",
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: event.id,
                        title: event.title,
                        start: event.start,
                        end: event.end,
                        color: event.color
                    },
                    success: function(response) {
                        if (response) {
                            return response;
                        }
                    },
                    error: function() {
                        alert('Failed to update event.');
                    }
                });
            }


            $('#addEventButton').on('click', async function() {
                const id = $('#eventId').val() || null;
                var title = $('#eventTitle').val();
                var color = $('#eventColor').val();
                var startDate = $('#eventStartDate').val();
                var endDate = $('#eventEndDate').val();

                if (title && startDate && endDate) {
                    var newEvent = {
                        id: id,
                        title: title,
                        start: startDate,
                        end: endDate,
                        color: color
                    };

                    if (id) {
                        newEvent.id = id;
                        // Update existing event
                        calendar.getEventById(id).remove();
                        await editEvent(newEvent);
                    } else {
                        // Create new event
                        const response = await addNewEvent(newEvent);
                        newEvent.id = response.id;
                    }

                    calendar.addEvent(newEvent);
                    $('#eventModal').modal('hide');
                    $('#eventForm')[0].reset();


                } else {
                    alert('Please fill all required fields.');
                }
            });
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function(fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: "{{ route('admin.event_calendar.index') }}",
                        type: 'GET',
                        data: {
                            start: fetchInfo.startStr,
                            end: fetchInfo.endStr,
                            type: 'json'
                        },
                        success: function(response) {
                            successCallback(response);
                        },
                        error: function() {
                            failureCallback();
                        }
                    });
                },
                themeSystem: 'bootstrap',
                eventColor: '#378006', // Example color for events
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                contentHeight: 'auto',
                aspectRatio: 1.8,
                dayMaxEvents: true, // allow "more" link when too many events
                eventTextColor: '#ffffff', // Text color for events
                eventBackgroundColor: '#000000', // Background color for events
                eventBorderColor: '#000000', // Border color for events
                eventDidMount: function(info) {
                    var eventTitle = info.el.querySelector('.fc-event-title');
                    if (eventTitle) {
                        eventTitle.style.whiteSpace = 'normal';
                    }
                },
                dateClick: function(info) {
                    // Show modal to create new event
                    $('#eventForm')[0].reset();
                    $('#eventId').val('');
                    $('#eventModal').modal('show');
                    const currentDateTime = toISOLocal(new Date(info.date));
                    $('#eventStartDate').val(currentDateTime);
                    $('#eventEndDate').val(currentDateTime);
                },
                eventClick: function(info) {
                    // Show modal to edit existing event
                    $('#eventModal').modal('show');
                    $('#eventTitle').val(info.event.title);
                    $('#eventColor').val(info.event.backgroundColor);
                    $('#eventStartDate').val(toISOLocal(new Date(info.event.start)));
                    if (info.event.end) {
                        $('#eventEndDate').val(toISOLocal(new Date(info.event.end)));
                    } else {
                        $('#eventEndDate').val(toISOLocal(new Date(info.event.start)));
                    }

                    $('#eventId').val(info.event.id);
                    // Add more fields as needed
                },
                eventDataTransform: function(eventData) {
                    if (eventData.end) {
                        eventData.end = new Date(eventData.end);
                        eventData.end.setDate(eventData.end.getDate());
                    }
                    return eventData;
                }
            });
            calendar.render();
        });
    </script>
@endsection
