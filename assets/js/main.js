// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

// Dropdown Toggle
let user = document.querySelector(".user");
let userDropdown = document.querySelector(".user-dropdown");

user.addEventListener("click", function (event) {
  event.stopPropagation();
  userDropdown.classList.toggle("active");
});

// Close dropdown when clicking outside
document.addEventListener("click", function (event) {
  if (!user.contains(event.target) && !userDropdown.contains(event.target)) {
    userDropdown.classList.remove("active");
  }
});

// Toggle active class on like button
document.querySelectorAll('.like-button').forEach(button => {
  button.addEventListener('click', () => {
    button.classList.toggle('active');
  });
});
