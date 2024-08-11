document.addEventListener("DOMContentLoaded", function () {
    var multipleBarChart = document.getElementById("multipleBarChart").getContext("2d");

    var myMultipleBarChart = new Chart(multipleBarChart, {
        type: "bar",
        data: {
            labels: [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ],
            datasets: [{
                    label: "Total Users",
                    backgroundColor: "#177dff",
                    borderColor: "#177dff",
                    data: usersPerMonth,
                },
                {
                    label: "Total News",
                    backgroundColor: "#f3545d",
                    borderColor: "#f3545d",
                    data: newsPerMonth,
                }
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: "bottom",
            },
            title: {
                display: true,
                text: "Total Users and News per Month",
            },
            tooltips: {
                mode: "index",
                intersect: false,
            },
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true,
                }],
            },
        },
    });

    var pieChart = document.getElementById("pieChart").getContext("2d");

    var myPieChart = new Chart(pieChart, {
        type: "pie",
        data: {
            datasets: [{
                data: [totalUsersCurrentMonth, totalNewsCurrentMonth],
                backgroundColor: ["#177dff", "#f3545d"],
                borderWidth: 0,
            }],
            labels: ["Total Users", "Total News"],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: "bottom",
                labels: {
                    fontColor: "rgb(154, 154, 154)",
                    fontSize: 11,
                    usePointStyle: true,
                    padding: 20,
                },
            },
            pieceLabel: {
                render: "percentage",
                fontColor: "white",
                fontSize: 14,
            },
            tooltips: false,
            layout: {
                padding: {
                    left: 20,
                    right: 20,
                    top: 20,
                    bottom: 20,
                },
            },
        },
    });
});
