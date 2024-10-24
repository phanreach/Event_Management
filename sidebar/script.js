const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});

function checkScreenSize() {
  const sidebar = document.querySelector("#sidebar");
  const screenWidth = window.innerWidth;

  if (screenWidth <= 1500 && sidebar.classList.contains("expand")) {
    sidebar.classList.remove("expand");
  } else {
    sidebar.classList.add("expand");
  }
}

window.addEventListener("resize", checkScreenSize);

checkScreenSize();
