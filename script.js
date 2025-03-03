// Fonction de recherche AJAX
function searchMember() {
    let searchQuery = document.getElementById("searchInput").value;

    fetch("search.php?query=" + searchQuery)
        .then(response => response.text())
        .then(data => {
            document.getElementById("teamTable").innerHTML = data;
        })
        .catch(error => console.error("Erreur:", error));
}

// Suppression en AJAX
document.addEventListener("DOMContentLoaded", function () {
    let deleteButtons = document.querySelectorAll(".delete-btn");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            let userId = this.getAttribute("data-id");

            if (confirm("Voulez-vous vraiment supprimer cet enregistrement ?")) {
                fetch("delete.php?id=" + userId, { method: "GET" })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        document.getElementById("row_" + userId).remove();
                    } else {
                        alert("Erreur lors de la suppression.");
                    }
                })
                .catch(error => console.error("Erreur:", error));
            }
        });
    });
});
