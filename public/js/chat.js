/** @format */

// document.querySelector('.chat[data-chat=person2]').classList.add('active-chat')
// document.querySelector('.person[data-chat=1]').classList.add('active')

$(".person").click(function () {
  $("#conversation_fil").html("");
  $("#conversation_start").html("");

  $(".person").removeClass("active");
  $(".person").removeClass("active-chat");

  $(this).addClass("active");
  $(this).addClass("active-chat");

  $("#name").html($(this).children(".name").text());
  $.ajax({
    type: "GET",
    url: "getMessagePrive",
    async: true,
    data: { id: $(this).data("chat") },
    dataType: "json",
    cache: false,
  })
    .done(function (result) {
      console.log(result);
      constructChat(result.allMessage, result.idCurrentUser);
    })
    .fail(function (result) {
      console.log(result);
    });
});

function constructChat(message, id) {
  let date = "";
  let chat = "";

  date += '<div class="conversation-start">';
  date += "<span>";
  date += message[0].createdAt
  date += "</span>";
  date += "</div>";

  for (let i in message) {
    if (id == message[i].user_issuer) {
      chat += "<div class='bubble me'>" + message[i].contenue + "</div>";
    } else {
      chat += "<div class='bubble you'>" + message[i].contenue + "</div>";
    }
  }



  $("#conversation_fil").append(chat);
  $("#conversation_start").html(date);
}

// let friends = {
//     list: document.querySelector("ul.people"),
//     all: document.querySelectorAll(".left .person"),
//     name: "",
//   },
//   chat = {
//     container: document.querySelector(".container .right"),
//     current: null,
//     person: null,
//     name: document.querySelector(".container .right .top .name"),
//   };

// friends.all.forEach((f) => {
//   f.addEventListener("mousedown", () => {
//     f.classList.contains("active") || setAciveChat(f);
//   });
// });

// function setAciveChat(f) {
//   friends.list.querySelector(".active").classList.remove("active");
//   f.classList.add("active");
//   chat.current = chat.container.querySelector(".active-chat");
//   chat.person = f.getAttribute("data-chat");
//   chat.current.classList.remove("active-chat");
//   chat.container
//     .querySelector('[data-chat="' + chat.person + '"]')
//     .classList.add("active-chat");
//   friends.name = f.querySelector(".name").innerText;
//   chat.name.innerHTML = friends.name;
// }
