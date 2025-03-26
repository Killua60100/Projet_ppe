function loadUsers() {
  fetch('../requete/get_users.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('users-list').innerHTML = data;
    });
}

function checkUrlForPage() {
  const urlParams = new URLSearchParams(window.location.search);
  const page = urlParams.get('page');
  if (page) {
    handlePageChange(page);
  }
}

window.onload = function() {
  loadUsers();
  checkUrlForPage();
};