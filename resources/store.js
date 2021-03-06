import dayjs from "dayjs";

export default {
    state: {
        calendars: [],
        calendarOptions: {
            type: '4days',
            types: ['month', 'week', '4days', 'day', 'year'],
            date: dayjs(),
        },
        openEvent: null,
    },
    mutations: {
        setTheCalendarType(state, value) {
            state.calendarOptions = Object.assign(state.calendarOptions, {
                type: value,
            })
        },
        setCalendarOptions(state, options) {
            state.calendarOptions = Object.assign(state.calendarOptions, options);
        },
        incrementByType(state) {
            switch (state.calendarOptions.type) {
                case "month":
                    state.calendarOptions.date = state.calendarOptions.date.add(1, 'month');
                    return;
                case "week":
                    state.calendarOptions.date = state.calendarOptions.date.add(1, 'week');
                    return;
                case "4days":
                    state.calendarOptions.date = state.calendarOptions.date.add(4, 'days');
                    return;
                case "5days":
                    state.calendarOptions.date = state.calendarOptions.date.add(5, 'days');
                    return;
                case "day":
                default:
                    state.calendarOptions.date = state.calendarOptions.date.add(1, 'day');
                    return;
            }
        },
        decrementByType(state) {
            switch (state.calendarOptions.type) {
                case "month":
                    state.calendarOptions.date = state.calendarOptions.date.subtract(1, 'month');
                    return;
                case "week":
                    state.calendarOptions.date = state.calendarOptions.date.subtract(1, 'week');
                    return;
                case "4days":
                    state.calendarOptions.date = state.calendarOptions.date.subtract(4, 'days');
                    return;
                case "5days":
                    state.calendarOptions.date = state.calendarOptions.date.subtract(5, 'days');
                    return;
                case "day":
                default:
                    state.calendarOptions.date = state.calendarOptions.date.subtract(1, 'day');
                    return;
            }
        }
    },
    actions: {
        openEvent({ state }, event) {
            state.openEvent = event;
        }
    },
    getters: {
        calendarOptions(state) {
            return state.calendarOptions
        },
        events(state, getters) {
            return getters.datesInSelectedMonth.reduce((events, day) => {
                return getters.calendars.reduce((calendars, calendar) => ({
                    ...calendars,
                    ...calendar.repeatable
                        .map(event => ({ event, occurrences: event.nextOccurrences(dayjs(day).startOf('day'), dayjs(day).endOf('day'))}))

                        // Ensure we're only attempting to render events for the current set of occurrences, where the event has started.
                        .reduce((d, { event: { calendarEvent }, occurrences }) => {
                            return {
                                ...occurrences.reduce((allEvents, rule) => {
                                    const calEvent = new CalendarEvent(calendarEvent);
                                    calEvent.setDate(dayjs(rule));
                                    return {
                                        ...allEvents,
                                        [dayjs(rule).format('YYYY-MM-DD')]: [
                                            ...(allEvents[dayjs(rule).format('YYYY-MM-DD')] ? (
                                                allEvents[dayjs(rule).format('YYYY-MM-DD')]
                                            ) : []),
                                            calEvent,
                                        ]
                                    }
                                }, d)
                            };
                        }, {})
                }), events)
            }, {});
        },
        fullDaysInMonth(state) {
            return createArray(dayjs(state.calendarOptions.date).daysInMonth());
        },
        daysInSelectedMonth(state) {
            switch (state.calendarOptions.type) {
                case "month":
                    return createArray(dayjs(state.calendarOptions.date).daysInMonth());
                case "week":
                    return [
                        dayjs(state.calendarOptions.date).subtract(1, 'day').$d.getDate(),
                        dayjs(state.calendarOptions.date).$d.getDate(),
                        dayjs(state.calendarOptions.date).add(1, 'day').$d.getDate(),
                        dayjs(state.calendarOptions.date).add(2, 'days').$d.getDate(),
                        dayjs(state.calendarOptions.date).add(3, 'days').$d.getDate(),
                        dayjs(state.calendarOptions.date).add(4, 'days').$d.getDate(),
                        dayjs(state.calendarOptions.date).add(5, 'days').$d.getDate(),
                    ];
                case "4days":
                    return [
                        dayjs(state.calendarOptions.date).subtract(1, 'day').$d.getDate(),
                        dayjs(state.calendarOptions.date).$d.getDate(),
                        dayjs(state.calendarOptions.date).add(1, 'day').$d.getDate(),
                        dayjs(state.calendarOptions.date).add(2, 'days').$d.getDate(),
                    ];
                case "5days":
                    return [
                        dayjs(state.calendarOptions.date).subtract(1, 'day').$d.getDate(),
                        dayjs(state.calendarOptions.date).$d.getDate(),
                        dayjs(state.calendarOptions.date).add(1, 'day').$d.getDate(),
                        dayjs(state.calendarOptions.date).add(2, 'days').$d.getDate(),
                        dayjs(state.calendarOptions.date).add(3, 'days').$d.getDate(),
                    ];
                case "day":
                default:
                    return [
                        dayjs(state.calendarOptions.date).$d.getDate(),
                    ];
            }
        },
        datesInSelectedMonth(state) {
            switch (state.calendarOptions.type) {
                case "month":
                    return createArray(dayjs(state.calendarOptions.date).daysInMonth()).map(day => (
                        dayjs(state.calendarOptions.date.year() + '-' + (state.calendarOptions.date.month() + 1) + '-' + day)
                    ));
                case "week":
                    return [
                        dayjs(state.calendarOptions.date).subtract(1, 'day'),
                        dayjs(state.calendarOptions.date),
                        dayjs(state.calendarOptions.date).add(1, 'day'),
                        dayjs(state.calendarOptions.date).add(2, 'days'),
                        dayjs(state.calendarOptions.date).add(3, 'days'),
                        dayjs(state.calendarOptions.date).add(4, 'days'),
                        dayjs(state.calendarOptions.date).add(5, 'days'),
                    ];
                case "4days":
                    return [
                        dayjs(state.calendarOptions.date).subtract(1, 'day'),
                        dayjs(state.calendarOptions.date),
                        dayjs(state.calendarOptions.date).add(1, 'day'),
                        dayjs(state.calendarOptions.date).add(2, 'days'),
                    ];
                case "5days":
                    return [
                        dayjs(state.calendarOptions.date).subtract(1, 'day'),
                        dayjs(state.calendarOptions.date),
                        dayjs(state.calendarOptions.date).add(1, 'day'),
                        dayjs(state.calendarOptions.date).add(2, 'days'),
                        dayjs(state.calendarOptions.date).add(3, 'days'),
                    ];
                case "day":
                default:
                    return [
                        dayjs(state.calendarOptions.date).$d.getDate(),
                    ];
            }
        },
        calendars(state, rootGetters) {
            return (rootGetters?.features?.calendar ?? []).concat(
                rootGetters?.features?.reminders ?? []
            );
        },
    }
};
