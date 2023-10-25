<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller {
    public function index(Request $request) {
        // ดึงข้อมูลรายการรายรับ/รายจ่าย และค้นหาตามชื่อ-นามสกุล
        $query = $request->input('query');
        $transactions = Transaction::where(function($q) use ($query) {
            $q->where('first_name', 'LIKE', "%$query%")
              ->orWhere('last_name', 'LIKE', "%$query%");
        })->get();
    
        return view('transactions.index', compact('transactions'));
    }

    public function store(Request $request) {
        // ตรวจสอบและตรวจสอบข้อมูลที่ส่งมาจากแบบฟอร์ม
        $validatedData = $request->validate([
            'prefix' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'birthdate' => 'required|date',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric',
            'transaction_type' => 'required',
        ]);
    
        // หากผ่านการตรวจสอบข้อมูล บันทึกข้อมูลในฐานข้อมูล
        $transaction = new Transaction();
        $transaction->prefix = $request->input('prefix');
        $transaction->first_name = $request->input('first_name');
        $transaction->last_name = $request->input('last_name');
        $transaction->birthdate = $request->input('birthdate');
        $transaction->transaction_date = $request->input('transaction_date');
        $transaction->amount = $request->input('amount');
        $transaction->transaction_type = $request->input('transaction_type');
        $transaction->created_at = now();
    
        // บันทึกไฟล์รูปภาพ (หากมีการอัปโหลด)
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $transaction->profile_image = $imagePath;
        }
    
        $transaction->save();
    
        return redirect()->route('transactions.index')->with('success', 'บันทึกรายการรายรับ/รายจ่ายเรียบร้อยแล้ว');
    }

    public function edit($id) {
        // ค้นหารายการรายรับ/รายจ่ายที่ต้องการแก้ไข
        $transaction = Transaction::find($id);
    
        if (!$transaction) {
            return redirect()->route('transactions.index')->with('error', 'ไม่พบรายการรายรับ/รายจ่าย');
        }
    
        return view('transactions.edit', ['transaction' => $transaction]);
    }
    

    public function update(Request $request, $id) {
        $transaction = Transaction::find($id);
    
        if (!$transaction) {
            return redirect()->route('transactions.index')->with('error', 'ไม่พบรายการรายรับ/รายจ่าย');
        }
    
        $validatedData = $request->validate([
            'prefix' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'birthdate' => 'required|date',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric',
            'transaction_type' => 'required',
        ]);
    
        $transaction->prefix = $request->input('prefix');
        $transaction->first_name = $request->input('first_name');
        $transaction->last_name = $request->input('last_name');
        $transaction->birthdate = $request->input('birthdate');
        $transaction->transaction_date = $request->input('transaction_date');
        $transaction->amount = $request->input('amount');
        $transaction->transaction_type = $request->input('transaction_type');
    
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $transaction->profile_image = $imagePath;
        }
    
        $transaction->save();
    
        return redirect()->route('transactions.index')->with('success', 'อัปเดตรายการรายรับ/รายจ่ายเรียบร้อยแล้ว');
    }

    public function delete($id) {
        // ค้นหารายการรายรับ/รายจ่ายที่ต้องการลบ
        $transaction = Transaction::find($id);
    
        if (!$transaction) {
            // หากไม่พบรายการรายรับ/รายจ่าย ให้เราเปลี่ยนเส้นทางไปหน้ารายการรายรับ/รายจ่ายหลัก
            return redirect()->route('transactions.index')->with('error', 'ไม่พบรายการรายรับ/รายจ่าย');
        }
    
        $transaction->delete();
    
        return redirect()->route('transactions.index')->with('success', 'ลบรายการรายรับ/รายจ่ายเรียบร้อยแล้ว');
    }
}
