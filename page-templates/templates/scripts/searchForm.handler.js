document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("searchForm");
  let toolType = "tools";
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const input = document.querySelector('input[type="text"]').value;
    console.log(input, toolType);
    window.location.href = `${window.location.href}/search-results?query=${encodeURIComponent(input)}&type=${toolType}`;
  });
  form.querySelectorAll('.radio-div label').forEach((radio) => {
    radio.addEventListener("click", (e) => {
      toolType = radio.querySelector('input[type="radio"]').value;
    });
  });
});
