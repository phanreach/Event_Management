const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});

function checkScreenSize() {
  const sidebar = document.querySelector("#sidebar");
  const screenWidth = window.innerWidth;

  // Close the sidebar if the screen width is below 992px and it is expanded
  if (screenWidth < 992 && sidebar.classList.contains("expand")) {
    sidebar.classList.remove("expand");
  }

  if (screenWidth >= 1200 && sidebar.classList.contains("expand")) {
    sidebar.classList.add("expand");
  }
}

window.addEventListener("resize", checkScreenSize);

checkScreenSize();