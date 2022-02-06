Spork.setupStore({
    Calendar: require("./store").default,
})

Spork.routesFor('calendar', [
    Spork.authenticatedRoute('/calendar', require('./Calendar/Calendar').default),
]);