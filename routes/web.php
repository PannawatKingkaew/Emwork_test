<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// แสดงรายการรายรับ/รายจ่าย
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

// บันทึกรายการรายรับ/รายจ่าย
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

// เส้นทางแสดงแบบฟอร์มแก้ไข
Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');

// เส้นทางอัปเดตข้อมูลหลังจากแก้ไข
Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');

// ลบรายการรายรับ/รายจ่าย
Route::get('/transactions/{id}', [TransactionController::class, 'delete'])->name('transactions.delete');

Route::get('/', [TransactionController::class, 'index']);

