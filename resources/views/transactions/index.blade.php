<!DOCTYPE html>
<html>
<head>
    <title>บันทึกรายการรายรับ/รายจ่าย</title>
</head>
<body>
    <h1>บันทึกรายการรายรับ/รายจ่าย</h1>

    <form action="{{ route('transactions.store') }}" method="post" enctype="multipart/form-data">
    @csrf
        <label for="prefix">คำนำหน้าชื่อ:</label>
        <select name="prefix" id="prefix">
            <option value="นาย">นาย</option>
            <option value="นาง">นาง</option>
            <option value="นางสาว">นางสาว</option>
        </select>

        <label for="first_name">ชื่อ:</label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="last_name">นามสกุล:</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="birthdate">วันเดือนปีเกิด:</label>
        <input type="date" name="birthdate" id="birthdate" required>
        <br/>

        <label for="transaction_date">วันที่ทำรายการ:</label>
        <input type="date" name="transaction_date" id="transaction_date" required>

        <label for="amount">จำนวนเงิน:</label>
        <input type="text" name="amount" id="amount" required>

        <label for="transaction_type">ประเภทรายการ:</label>
        <select name="transaction_type" id="transaction_type">
            <option value="รายรับ">รายรับ</option>
            <option value="รายจ่าย">รายจ่าย</option>
        </select>
        <br/>

        <label for="profile_image">รูปภาพโปรไฟล์:</label>
        <input type="file" name="profile_image" id="profile_image">
        <br/> 

        <button type="submit">บันทึก</button>
    </form>

<!-- แสดงรายการสมาชิก -->
<h2>รายการ</h2>
<form action="{{ route('transactions.index') }}" method="get">
    <label for="query">ค้นหาชื่อ-นามสกุล:</label>
    <input type="text" name="query" id="query">
    <button type="submit">ค้นหา</button> 
</form>
<button id="sort-by-age">เรียงลำดับตามอายุ</button> 
<table>
    <thead>
        <tr>
            <th>รูป</th>
            <th>คำนำหน้าชื่อ</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>วันเดือนปีเกิด</th>
            <th>อายุ</th>
            <th>ประเภทรายรับ/รายจ่าย</th>
            <th>จำนวนเงิน</th>
            <th>วันที่เกิดรายการ</th>
            <th>อัพเดท</th>
            <th>การจัดการ</th> <!-- เพิ่มคอลัมน์นี้สำหรับปุ่มแก้ไขและลบ -->
        </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>
                @if($transaction->profile_image)
                    <img src="{{ asset('storage/' . $transaction->profile_image) }}" alt="โปรไฟล์" style="width: 100px; height: 100px;">
                @else
                    <img src="{{ asset('default_profile_image.jpg') }}" alt="โปรไฟล์" style="width: 100px; height: 100px;">
                @endif
            </td>
            <td>{{ $transaction->prefix }}</td>
            <td class="first_name">{{ $transaction->first_name }}</td>
            <td class="last_name">{{ $transaction->last_name }}</td>
            <td class="birthdate">{{ $transaction->birthdate }}</td>
            <td class="age">{{ $transaction->age }}</td>
            <td>{{ $transaction->transaction_type }}</td>
            <td>{{ $transaction->amount }} บาท</td>
            <td>{{ $transaction->transaction_date }}</td>
            <td>{{ $transaction->created_at }}</td>
            <td>
                <a href="{{ route('transactions.edit', ['id' => $transaction->id]) }}">แก้ไข</a> |
                <a href="{{ route('transactions.delete', ['id' => $transaction->id]) }}">ลบ</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div id="ageChartContainer">
    <canvas id="ageChart"></canvas>
    <div id="ageCounts"></div>
</div>
</body>

<script src="js/sort.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/chart.js"></script>

</html>

