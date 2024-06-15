<style>
    .side-logo {
        width: 180px;
        height: 180px;
        object-fit: contain !important;
    }
</style>
<div class="sidebar_all">
    <div class="logo side-logo"></div>
    <br>
    <br>
    <div class="links">
        <h3>
            <span class="icon"><i class="fa-solid fa-chart-simple"> </i></span> V.ELG FORMS
        </h3>
        <a href="membership_forms.php">Membership Card Forms</a>
        <a href="view_members.php">Print Membership</a>
        <a href="loans_agreement_forms.php">Loan Agreement Forms</a>
        <a href="upload_loan_agreement.php">Upoad Loan Agreement</a>
        <a href="view_loan_agreements.php">View Loan Agreement</a>

        <a href="logout.php" class="log">
            <h3> <i class="fas fa-sign-out-alt"></i> LOGOUT</h3>
        </a>
    </div>

</div>
<button id="toggleButton">
    <i class="fa-solid fa-bars-staggered"></i>
</button>

<script>
    // Get the button and sidebar elements
    var toggleButton = document.getElementById("toggleButton");
    var sidebar = document.querySelector(".sidebar_all");
    var icon = toggleButton.querySelector("i");

    // Add click event listener to the button
    toggleButton.addEventListener("click", function() {
        // Toggle the visibility of the sidebar
        if (sidebar.style.display === "none" || sidebar.style.display === "") {
            sidebar.style.display = "block";
            icon.classList.remove("fa-bars-staggered");
            icon.classList.add("fa-xmark");
        } else {
            sidebar.style.display = "none";
            icon.classList.remove("fa-xmark");
            icon.classList.add("fa-bars-staggered");
        }
    });
</script>