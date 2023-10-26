var sortAscending = true; // ตัวแปรเพื่อตรวจสอบสถานะการเรียงลำดับ

document.getElementById('sort-by-age').addEventListener('click', function() {
    
    // ดึงรายการทั้งหมดออกมา
    var rows = document.querySelectorAll('table tbody tr');

    // แปลงข้อมูลเป็นอายุและจัดเก็บในอาร์เรย์
    var data = [];
    rows.forEach(function(row) {
        var age = parseInt(row.querySelector('.age').textContent);
        data.push({ row: row, age: age });
    });

    // สลับการเรียงลำดับ
    if (sortAscending) {
        data.sort(function(a, b) {
            return a.age - b.age;
        });
    } else {
        data.sort(function(a, b) {
            return b.age - a.age;
        });
    }

    // ลบรายการทั้งหมดจากตาราง
    var tbody = document.querySelector('table tbody');
    tbody.innerHTML = '';

    // แทรกรายการที่เรียงลำดับใหม่
    data.forEach(function(item) {
        tbody.appendChild(item.row);
    });

    // สลับสถานะการเรียงลำดับ
    sortAscending = !sortAscending;
});