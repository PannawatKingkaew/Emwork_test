<!DOCTYPE html>
<html>
<head>
    <title>แก้ไขรายการรายรับ/รายจ่าย</title>
</head>
<body>
    <h1>แก้ไขรายการรายรับ/รายจ่าย</h1>

    <form action="{{ route('transactions.update', ['id' => $transaction->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <label for="prefix">คำนำหน้าชื่อ:</label>
        <select name="prefix" id="prefix">
            <option value="นาย" {{ $transaction->prefix === 'นาย' ? 'selected' : '' }}>นาย</option>
            <option value="นาง" {{ $transaction->prefix === 'นาง' ? 'selected' : '' }}>นาง</option>
            <option value="นางสาว" {{ $transaction->prefix === 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
        </select>

        <label for="first_name">ชื่อ:</label>
        <input type="text" name="first_name" id="first_name" value="{{ $transaction->first_name }}" required>

        <label for="last_name">นามสกุล:</label>
        <input type="text" name="last_name" id="last_name" value="{{ $transaction->last_name }}" required>

        <label for="birthdate">วันเดือนปีเกิด:</label>
        <input type="date" name="birthdate" id="birthdate" value="{{ $transaction->birthdate }}" required>
        <br/> 

        <label for="transaction_date">วันที่ทำรายการ:</label>
        <input type="date" name="transaction_date" id="transaction_date" value="{{ $transaction->transaction_date }}" required>

        <label for="amount">จำนวนเงิน:</label>
        <input type="text" name="amount" id="amount" value="{{ $transaction->amount }}" required>

        <label for="transaction_type">ประเภทรายการ:</label>
        <select name="transaction_type" id="transaction_type">
            <option value="รายรับ" {{ $transaction->transaction_type === 'รายรับ' ? 'selected' : '' }}>รายรับ</option>
            <option value="รายจ่าย" {{ $transaction->transaction_type === 'รายจ่าย' ? 'selected' : '' }}>รายจ่าย</option>
        </select>
        <br/> 

        <label for="profile_image">รูปภาพโปรไฟล์:</label>
        <input type="file" name="profile_image" id="profile_image">
        <br/> 

        <button type="submit">บันทึกการแก้ไข</button>
    </form>

    <a href="{{ route('transactions.index') }}">กลับสู่รายการรายรับ/รายจ่าย</a>
</body>
</html>
