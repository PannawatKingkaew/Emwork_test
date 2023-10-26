// ดึงข้อมูลจาก HTML
var FnameElements = document.querySelectorAll('.first_name');
var LnameElements = document.querySelectorAll('.last_name');
var BdateElements = document.querySelectorAll('.birthdate');
var ageElements = document.querySelectorAll('.age');

// สร้างรายการข้อมูลที่ต้องการ
var data = [];
for (var i = 0; i < FnameElements.length; i++) {
    var fname = FnameElements[i].textContent;
    var lname = LnameElements[i].textContent;
    var bdate = BdateElements[i].textContent.replace(/-/g, ''); // ลบเครื่องหมายขีด
    var age = parseInt(ageElements[i].textContent);
    var key = fname + lname + bdate;
    data.push([key, age]);
}

// จัดหมวดอายุและนับจำนวน
var ageCounts = {};
data.forEach(function(item) {
    var key = item[0];
    var age = item[1];
    if (!ageCounts[key]) {
        ageCounts[key] = age;
    } else if (ageCounts[key] < age) {
        ageCounts[key] = age;
    }
});

var ageLabels = Object.values(ageCounts);

// นับจำนวนข้อมูลของแต่ละอายุ
var ageData = {};
ageLabels.forEach(function(age) {
    ageData[age] = (ageData[age] || 0) + 1;
});

// แสดงผลลัพธ์
var ageCountsDiv = document.getElementById('ageCounts');
ageCountsDiv.style.fontSize = '18px';
ageCountsDiv.innerHTML = 'จำนวนแต่ละอายุ<br>';

Object.keys(ageData).forEach(function(age) {
    ageCountsDiv.innerHTML += age + ' ปี: ' + ageData[age] + ' คน' + '<br>';
});

// ตัวแปร canvas
var ctx = document.getElementById('ageChart').getContext('2d');

var ageColors = ageLabels.map(function(age) {
    var r = Math.floor(Math.random() * 256);
    var g = Math.floor(Math.random() * 256);
    var b = Math.floor(Math.random() * 256);
    return `rgba(${r}, ${g}, ${b})`;
});

// สร้างกราฟแท่ง
var ageChart = new Chart(ctx, {
    type: 'bar', // ประเภทของกราฟ
    data: {
        labels: Object.keys(ageData).map(function(age) {
            return age + ' ปี';
        }),
        datasets: [{
            label: 'จำนวนสมาชิก',
            data: Object.values(ageData), // ข้อมูลจำนวนสมาชิก
            backgroundColor: ageColors, // สีของแท่ง
            borderColor: ageColors, // เส้นขอบของแท่ง
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1 // กำหนด step ที่ต้องการ (เช่น 1)
            }
        }
    }
});
