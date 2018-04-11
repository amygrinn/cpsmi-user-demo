$(function() {


  $("#search_users_form").submit(function(event) {

    event.preventDefault()

    $.get(
      "/api/users?" + $.param({ search: $("#search").val() }),
      function(data) {

        data = JSON.parse(data)

        let htmlStr = ""

        if(data.length > 0) {

          data.forEach( function(user) {
            htmlStr += `<li>${user.name}, ${user.phone}, ${user.email}</li>`
          })

        } else {
          htmlStr = "No results found"
        }

        $("#results").html(htmlStr)
      }
    )
  })
})
