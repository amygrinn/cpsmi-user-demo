$(() => {
  Rx.Observable
  .fromEvent($("#search"), 'keyup')
  .map(() => $("#search").val()) // Get search string
  .do(val => !val && $("#results").html("")) // If input empty, clear results list
  .pipe(Rx.operators.debounceTime(500)) // Only request users at most every 500 ms
  .pipe(Rx.operators.switchMap( // switchMap only emits values from most recent request made
    search => Rx.Observable.fromPromise(
      $.get("/api/users?" + $.param({ search })).promise() // Request users
    ))
  )
  .filter(() => !!$("#search").val()) // Check to see if input cleared while requesting data
  .map(data => JSON.parse(data))
  .subscribe(data => { // Display results
    let htmlStr = ""

    if(data.length > 0) {
      data.forEach( function(user) {
        htmlStr += `<li>${user.name}, ${user.phone}, ${user.email}</li>`
      })
    } else {
      htmlStr = "No results found"
    }

    $("#results").html(htmlStr)
  })
})
