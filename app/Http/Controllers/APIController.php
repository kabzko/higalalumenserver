<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Bad_order;
use App\Models\Expense;
use App\Models\Item_batch;
use App\Models\Log;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\Stock_log;
use App\Models\Tax;
use App\Models\User;


use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class APIController extends Controller
{
    public function print_receipt(Request $request)
    {
        $store_name = $request->input('store_name');
        $store_address = $request->input('store_address');
        $store_contact = $request->input('store_contact');
        $store_fax = $request->input('store_fax');
        $store_vat = $request->input('store_vat');
        $cart = $request->input('cart');
        $total_discount = $request->input('total_discount');
        $total = $request->input('total');
        $cash = $request->input('cash');
        $change = $request->input('change');
        $vatsales = $request->input('vatsales');
        $vatamount = $request->input('vatamount');
        $vatexempt = $request->input('vatexempt');
        $zero = $request->input('zero');
        $customer_name = $request->input('customer_name');
        $receipt_date = $request->input('receipt_date');
        $receipt_si = $request->input('receipt_si');
        $receipt_cashier = $request->input('receipt_cashier');
        $receipt_ptu = $request->input('receipt_ptu');
        $receipt_ptudate = $request->input('receipt_ptudate');
        $receipt_valid = $request->input('receipt_valid');
        $connector = new WindowsPrintConnector("xprinter58");
        $printer = new Printer($connector);
        try {
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer -> text($store_name);
            $printer -> feed();
            $printer -> selectPrintMode();
            $printer -> text($store_address);
            $printer -> feed();
            $printer -> text($store_contact);
            $printer -> feed();
            $printer -> text($store_fax);
            $printer -> feed();
            $printer -> text($store_vat);
            $printer -> feed();
            $printer -> feed();
            $printer -> text("SALES INVOICE\n");
            $printer -> feed();
            $printer -> text("================================\n");
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            for ($i=0; $i < count(json_decode($cart)); $i++) { 
                $printer -> text(json_decode($cart)[$i]->text1);
                $printer -> text(json_decode($cart)[$i]->text2);
            }
            $printer -> text("================================\n");
            $printer -> text($total_discount);
            $printer -> feed();
            $printer -> text($total);
            $printer -> feed();
            $printer -> text($cash);
            $printer -> feed();
            $printer -> text($change);
            $printer -> feed();
            $printer -> feed();
            $printer -> text($vatsales);
            $printer -> feed();
            $printer -> text($vatamount);
            $printer -> feed();
            $printer -> text($vatexempt);
            $printer -> feed();
            $printer -> text($zero);
            $printer -> feed();
            $printer -> feed();
            $printer -> text($customer_name);
            $printer -> feed();
            $printer -> text("TIN     : ______________________");
            $printer -> feed();
            $printer -> text("ADDRESS : ______________________");
            $printer -> feed();
            $printer -> text("B STYLE : ______________________");
            $printer -> feed();
            $printer -> text("PWD/SC ID NO. : ________________");
            $printer -> feed();
            $printer -> feed();
            $printer -> text("SIGNATURE: _____________________");
            $printer -> feed();
            $printer -> feed();
            $printer -> text($receipt_date);
            $printer -> feed();
            $printer -> text($receipt_si);
            $printer -> feed();
            $printer -> text($receipt_cashier);
            $printer -> feed();
            $printer -> text("CHECKOUT: _____________________");
            $printer -> feed();
            $printer -> feed();
            $printer -> text("PTU No.");
            $printer -> feed();
            $printer -> text($receipt_ptu);
            $printer -> feed();
            $printer -> text($receipt_ptudate);
            $printer -> feed();
            $printer -> text($receipt_valid);
            $printer -> feed();
            $printer -> feed();
            $printer -> text("THIS SERVES AS YOUR SALES INVOICE. THIS INVOICE SHALL BE VALID FOR FIVE(5) YEARS FROM THE DATE OF THE PERMIT TO USE.");
            $printer -> feed();
            $printer -> feed();
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("THANK YOU FOR SHOPPING!");
            $printer -> text(" \n");
            $printer -> text(" \n");
            $printer -> text(" \n");
            $printer -> pulse();
            $printer -> close();
        } catch (Exception $e) {
            return "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }

    public function open_cash_drawer()
    {
        $connector = new WindowsPrintConnector("xprinter58");
        $printer = new Printer($connector);
        $printer -> pulse();
        $printer -> close();
    }

    public function change_super_admin(Request $request)
    {
        $oldpass = $request->input("oldpass");
        $newpass = $request->input("newpass");
        $user = User::all();
        if (Hash::check($oldpass, $user[0]->password)) {
            User::where("id", $user[0]->id)->update(["password" => Hash::make($newpass)]);
        } else {
            return 0;
        }
    }

    public function super_admin_login(Request $request)
    {
        $password = $request->input("password");
        $user = User::all();
        if (Hash::check($password, $user[0]->password)) {
            Log::create(["description" => "Login at ".date('l jS \of F Y h:i:s A')]);
            return 1;
        } else {
            return 0;
        }
    }

    public function load_profiles(Request $request)
    {
        return Profile::select("id","name")->get();
    }

    public function profile_login(Request $request)
    {
        $profileid = $request->input("profileid");
        $pin = $request->input("pin");
        $user = Profile::where("id", $profileid)->get();
        if ($user[0]->status == "locked") {
            return 2;
        } else {
            if (Hash::check($pin, $user[0]->pin)) {
                Profile::where("id", $profileid)->update(["tries" => 0]);
                return $user;
            } else {
                if ($user[0]->tries == 4) {
                    Profile::where("id", $profileid)->update(["status" => "locked"]);
                    return 2;
                } else {
                    Profile::where("id", $profileid)->update(["tries" => ($user[0]->tries++)]);
                    return 1;
                }
            }
        }
    }

    public function load_inventory_by_store(Request $request)
    {
        return Item_batch::join("products", "item_batches.productId", "=", "products.id")->join("stock_logs", "item_batches.stockId", "=", "stock_logs.id")->select("item_batches.stockId", "products.barcode", "products.category", "stock_logs.cost", "products.discount", "item_batches.productId", "item_batches.id", "products.name", "products.netweight", "item_batches.price", "item_batches.quantity", "products.threshold", "item_batches.batchNum")->selectRaw("CONCAT(SUBSTRING(DAYNAME(item_batches.updated_at), 1, 3), ', ', SUBSTRING(MONTHNAME(item_batches.updated_at), 1, 3), ' ', DAY(item_batches.updated_at), ', ', YEAR(item_batches.updated_at), ' ', TIME_FORMAT(TIME(item_batches.updated_at), '%h:%i:%s %p')) as datetime")->where("item_batches.quantity", "!=", "0")->orderBy("products.barcode", "desc")->orderBy("item_batches.id", "asc")->get();
    }

    public function load_inventory_cart(Request $request)
    {
        return Item_batch::join("products", "item_batches.productId", "=", "products.id")->select("products.barcode", "products.discount", "products.id", "products.name", "products.netweight", "products.threshold")->selectRaw("SUM(item_batches.quantity) as quantity")->selectRaw("MAX(item_batches.price) as price")->where("item_batches.quantity","!=","0")->groupBy("products.barcode")->get();
    }

    public function checkout_purchase(Request $request)
    {
        $tax = Tax::select("tax")->get();
        $count = Purchase::whereDate("created_at", date("Y-m-d"))->count();
        $token = date("Ymd").$count;
        $cart = $request->input("cart");
        $profilename = $request->input("profile_name");
        $name = $request->input("name");
        $cash = $request->input("cash");
        $benefit = $request->input("benefit");
        $type = $request->input("type");
        $status = $request->input("status");
        $index = 0;
        foreach(json_decode($cart) as $x) {
            $index++;
            $quantity = 0;
            $stock = Item_batch::select("id", "quantity")->where("productId", $x->id)->where("quantity", "!=", "0")->orderBy("id", "asc")->get();
            foreach($stock as $z) {
                if ($quantity == 0) {
                    $quantity = $x->ordered - $z->quantity;
                } else {
                    $quantity = $quantity - $z->quantity;
                }
                if ($quantity >= 1) {
                    Item_batch::where("id", $z->id)->update(["quantity" => max(0, ($z->quantity - $x->ordered))]);
                } else {
                    Item_batch::where("id", $z->id)->update(["quantity" => max(0, (abs($quantity)))]);
                    break;
                }
            }
            Purchase::create(["orderId" => $token, "cashierName" => $profilename, "name" => $x->name, "price" => $x->price, "quantity" => $x->ordered, "vat" => $tax[0]->tax, "benefits" => $benefit, "discounts" => $x->discount, "customerName" => $name, "cash" => $cash, "type" => $type, "status" => $status]);
            if (count(json_decode($cart)) == $index) {
                return Purchase::select("orderId", "name", "price", "quantity", "vat", "benefits", "discounts", "customerName", "cash", "type")->selectRaw("CONCAT(SUBSTRING(DAYNAME(created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(created_at), 1, 3), ' ', DAY(created_at), ', ', YEAR(created_at), ' ', TIME_FORMAT(TIME(created_at), '%h:%i:%s %p')) as datetime")->where("orderId", $token)->get();
            }
        }
    }

    public function load_attendance_by_store(Request $request)
    {
        return Purchase::select("type", "orderId", "cashierName", "created_at", "price", "quantity", "vat", "customerName")->selectRaw("sum((price - (price * discounts)) * quantity) as total")->selectRaw("CONCAT(SUBSTRING(DAYNAME(created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(created_at), 1, 3), ' ', DAY(created_at), ', ', YEAR(created_at)) as date")->selectRaw("TIME_FORMAT(TIME(created_at), '%h:%i %p') as time")->groupBy("orderId")->orderBy("created_at", "desc")->get();  
    }

    public function load_selected_receipt(Request $request)
    {
        $order_id = $request->input("order_id");
        return Purchase::select("type", "orderId", "price", "quantity", "cash", "created_at", "cashierName", "customerName", "vat", "benefits", "discounts", "name")->selectRaw("CONCAT(SUBSTRING(DAYNAME(created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(created_at), 1, 3), ' ', DAY(created_at), ', ', YEAR(created_at), ' ', TIME_FORMAT(TIME(created_at), '%h:%i %p')) as datetime")->selectRaw("CONCAT(YEAR(created_at), '-', MONTH(created_at), '-', DAY(created_at)) as num_date")->where("orderId", $order_id)->orderBy("name", "asc")->get();
    }

    public function new_profile(Request $request)
    {
        $name = $request->input("name");
        $pin = $request->input("pin");
        Profile::create(["name" => $name, "pin" => Hash::make($pin), "status" => "unlocked"]);
    }

    public function change_profile_name(Request $request)
    {
        $id = $request->input("id");
        $old_name = $request->input("old_name");
        $new_name = $request->input("new_name");
        $checkname = Profile::where("name", $new_name)->get();
        if ($checkname->isEmpty()) {
            Profile::where("id", $id)->update(["name" => $new_name]);
            return 1;
        } else {
            return 2;
        }
    }

    public function update_pin(Request $request)
    {
        $profile_id = $request->input("profile_id");
        $pin = $request->input("pin");
        Profile::where("id", $profile_id)->update(["pin" => Hash::make($pin), "tries" => 0, "status" => "unlocked"]);
    }

    public function delete_profile(Request $request)
    {
        $id = $request->input("id");
        $name = $request->input("name");
        Profile::where("id", $id)->where("name", $name)->delete();
    }

    public function update_product_details(Request $request)
    {
        $id = $request->input("id");
        $barcode = $request->input("barcode");
        $name = $request->input("name");
        $net_weight = $request->input("net_weight");
        $lowstock = $request->input("lowstock");
        Product::where("id", $id)->update(["name" => $name, "barcode" => $barcode, "price" => $price, "netWight" => $net_weight, "threshold" => $lowstock]);
    }

    public function update_product_discount(Request $request)
    {
        $id = $request->input("id");
        $new_discount = $request->input("new_discount");
        Product::where("id", $id)->update(["discount" => ($new_discount/ 100)]);
    }

    public function load_tax(Request $request)
    {
        return Tax::select("tax")->get();
    }

    public function update_vat_value(Request $request)
    {
        $user_id = $request->input("user_id");
        $vat = $request->input("vat");
        Tax::where("id", 1)->update(["tax" => ($vat / 100)]);
    }

    public function load_sales_analysis(Request $request)
    {
        $month = $request->input("month");
        $dailyrevenue = Purchase::selectRaw("SUM(price * quantity) as revenue")->selectRaw("MONTH(created_at) as month")->selectRaw("DAY(created_at) as day")->selectRaw("YEAR(created_at) as year")->selectRaw("DATE(created_at) as date")->where("type", "cash")->whereMonth("created_at", $month)->groupBy("date")->orderBy("created_at", "asc")->get();
        $dailyexpense = Expense::selectRaw("SUM(amount) as expense")->selectRaw("MONTH(created_at) as month")->selectRaw("DAY(created_at) as day")->selectRaw("YEAR(created_at) as year")->selectRaw("DATE(created_at) as date")->whereMonth("created_at", $month)->groupBy("date")->orderBy("created_at", "asc")->get();
        $monthlyrevenue = Purchase::selectRaw("SUM(price * quantity) as revenue")->selectRaw("MONTH(created_at) as month")->selectRaw("YEAR(created_at) as year")->where("type", "cash")->whereMonth("created_at", $month)->groupBy("month", "year")->orderBy("created_at", "asc")->get();
        $monthlygrossincome = Stock_log::selectRaw("SUM(cost * newAdded) as grossincome")->selectRaw("MONTH(created_at) as month")->selectRaw("YEAR(created_at) as year")->whereMonth("created_at", $month)->groupBy("month", "year")->orderBy("created_at", "asc")->get();
        $monthlyexpense = Expense::selectRaw("SUM(amount) as expense")->selectRaw("MONTH(created_at) as month")->selectRaw("YEAR(created_at) as year")->whereMonth("created_at", $month)->groupBy("month", "year")->orderBy("created_at", "asc")->get();
        $yearlyrevenue = Purchase::selectRaw("SUM(price * quantity) as revenue")->selectRaw("YEAR(created_at) as year")->where("type", "cash")->groupBy("year")->orderBy("created_at", "asc")->get();
        $yearlygrossincome = Stock_log::selectRaw("SUM(cost * newAdded) as grossincome")->selectRaw("YEAR(created_at) as year")->groupBy("year")->orderBy("created_at", "asc")->get();
        $yearlyexpense = Expense::selectRaw("SUM(amount) as expense")->selectRaw("YEAR(created_at) as year")->groupBy("year")->orderBy("created_at", "asc")->get();
        return response()->json([
            "dailyrevenue" => $dailyrevenue, 
            "dailyexpense" => $dailyexpense,
            "monthlyrevenue" => $monthlyrevenue,
            "monthlygrossincome" => $monthlygrossincome,
            "monthlyexpense" => $monthlyexpense,
            "yearlyrevenue" => $yearlyrevenue,
            "yearlygrossincome" => $yearlygrossincome,
            "yearlyexpense" => $yearlyexpense
        ]);
    }

    public function load_stock_delivery_logs(Request $request)
    {
        return Stock_log::join("products", "stock_logs.productId", "=", "products.id")->select("stock_logs.id", "stock_logs.productId", "stock_logs.siorNo", "stock_logs.supplierName", "stock_logs.newAdded", "stock_logs.cost", "products.barcode", "products.netWeight")->selectRaw("CONCAT(SUBSTRING(DAYNAME(stock_logs.created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(stock_logs.created_at), 1, 3), ' ', DAY(stock_logs.created_at), ', ', YEAR(stock_logs.created_at), ' ', TIME_FORMAT(TIME(stock_logs.created_at), '%h:%i:%s %p')) as datetime")->orderBy("stock_logs.created_at", "desc")->get();
    }

    public function record_product_stock(Request $request)
    {
        $index = 0;
        $cart = $request->input("cart");
        $siorno = $request->input("siorno");
        $supplier = $request->input("supplier");
        foreach(json_decode($cart) as $x) {
            $index++;
            $exist = Product::select("id")->selectRaw("COUNT(*) as count")->where("barcode", $x->product_barcode)->get();
            $batch = Item_batch::selectRaw("COUNT(*) as count")->where("productId", $exist[0]->id)->get();
            if ($exist[0]->count == 0) {
                $productid = Product::create(["name" => $x->product_name, "barcode" => $x->product_barcode, "netWeight" => $x->product_net_weight, "discount" => 0, "threshold" => 0, "category" => $x->product_category])->id;
                $stockid = Stock_log::create(["siorNo" => $siorno, "supplierName" => $supplier, "productId" => $productid, "cost" => $x->product_cost, "newAdded" => $x->product_quantity])->id;
                Item_batch::create(["batchNum" => 1, "stockId" => $stockid, "productId" => $productid, "price" => $x->product_price, "quantity" => $x->product_quantity]);
                if (count(json_decode($cart)) == $index) {
                    return 1;
                }
            } else {
                $stockid = Stock_log::create(["siorNo" => $siorno, "supplierName" => $supplier, "productId" => $exist[0]->id, "cost" => $x->product_cost, "newAdded" => $x->product_quantity])->id;
                Item_batch::create(["batchNum" => ($batch[0]->count + 1), "stockId" => $stockid, "productId" => $exist[0]->id, "price" => $x->product_price, "quantity" => $x->product_quantity]);
                if (count(json_decode($cart)) == $index) {
                    return 1;
                }
            }
        }
    }

    public function customers_name(Request $request)    
    {
        return Purchase::select("customerName")->where("customerName", "!=", "")->groupBy("customerName")->get();
    }

    public function load_category(Request $request)
    {
        return Product::select("category")->orderBy("category", "asc")->groupBy("category")->get();
    }

    public function load_supplier(Request $request)
    {
        return Stock_log::select("supplierName")->orderBy("supplierName", "asc")->groupBy("supplierName")->get();
    }

    public function products_leaderboard(Request $request)
    {
        $selected_month = $request->input("month");
        $selected_year = $request->input("year");
        return Purchase::select("name")->selectRaw("SUM(quantity) as sold")->whereMonth("created_at", $selected_month)->whereYear("created_at", $selected_year)->groupBy("name")->orderBy("sold", "desc")->get();
    }

    public function load_total_sales(Request $request)
    {
        return Purchase::selectRaw("round(SUM(price * quantity), 2) as totalsales")->where("type", "cash")->whereMonth("created_at", date("m"))->whereDay("created_at", date("d"))->whereYear("created_at", date("Y"))->get();
    }

    public function load_bad_orders(Request $request)
    {
        return Bad_order::join("item_batches", "bad_orders.batchId", "=", "item_batches.id")->join("products", "item_batches.productId", "=", "products.id")->select("bad_orders.id", "bad_orders.batchId", "item_batches.batchNum", "products.barcode", "products.name", "bad_orders.deducted", "item_batches.quantity")->selectRaw("CONCAT(SUBSTRING(DAYNAME(bad_orders.created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(bad_orders.created_at), 1, 3), ' ', DAY(bad_orders.created_at), ', ', YEAR(bad_orders.created_at), ' ', TIME_FORMAT(TIME(bad_orders.created_at), '%h:%i:%s %p')) as datetime")->orderBy("bad_orders.id",  "desc")->get();
    }

    public function deduct_bad_stocks(Request $request)
    {
        $batchid = $request->input("id");
        $quantity = $request->input("quantity");
        Bad_order::create(["batchId" => $batchid, "deducted" => $quantity]);
        $stock = Item_batch::select("quantity")->where("id", $batchid)->get();
        Item_batch::where("id", $batchid)->update(["quantity" => ($stock[0]->quantity - $quantity)]);
        return 1;
    }

    public function load_store_credit(Request $request)
    {
        return response()->json([
            "unpaid" => Purchase::select("type", "orderId", "cashierName", "price", "quantity", "vat", "customerName")->selectRaw("SUM((price - (price * discounts)) * quantity) as total")->selectRaw("CONCAT(SUBSTRING(DAYNAME(created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(created_at), 1, 3), ' ', DAY(created_at), ', ', YEAR(created_at)) as date")->selectRaw("TIME_FORMAT(TIME(created_at), '%h:%i %p') as time")->where("status", "unpaid")->groupBy("orderId")->orderBy("created_at", "desc")->get(),
            "paid" => Purchase::select("type", "orderId", "cashierName", "price", "quantity", "vat", "customerName")->selectRaw("SUM((price - (price * discounts)) * quantity) as total")->selectRaw("CONCAT(SUBSTRING(DAYNAME(created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(created_at), 1, 3), ' ', DAY(created_at), ', ', YEAR(created_at)) as date")->selectRaw("TIME_FORMAT(TIME(created_at), '%h:%i %p') as time")->where("status", "paid")->groupBy("orderId")->orderBy("created_at", "desc")->get()
        ]);
    }

    public function update_store_credit(Request $request) 
    {
        $orderid = $request->input("orderid");
        Purchase::where("orderId", $orderid)->update(["status" => "paid"]);
    }

    public function load_store_admin(Request $request)
    {
        return Profile::all();
    }

    public function load_system_printers()
    {
        exec("wmic printer get name", $output, $retval);
        return $output;
    }

    public function daily_sales_info(Request $request)
    {
        $date = $request->input("date");
        return Purchase::select("cashierName")->selectRaw("SUM(price * quantity) as total")->whereDate("created_at", $date)->where("type", "cash")->groupBy("cashierName")->orderBy("created_at", "asc")->get();
    }

    public function load_store_expenses(Request $request)
    {
        $selected_month = $request->input("month");
        $selected_year = $request->input("year");
        return Expense::select("id", "type", "amount")->selectRaw("CONCAT(SUBSTRING(DAYNAME(created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(created_at), 1, 3), ' ', DAY(created_at), ', ', YEAR(created_at), ' ', TIME_FORMAT(TIME(created_at), '%h:%i:%s %p')) as datetime")->selectRaw("CONCAT(SUBSTRING(DAYNAME(updated_at), 1, 3), ', ', SUBSTRING(MONTHNAME(updated_at), 1, 3), ' ', DAY(updated_at), ', ', YEAR(updated_at), ' ', TIME_FORMAT(TIME(updated_at), '%h:%i:%s %p')) as updatetime")->whereMonth("created_at", $selected_month)->whereYear("created_at", $selected_year)->orderBy("created_at", "desc")->get();
    }

    public function record_expenses(Request $request) 
    {
        $index = 0;
        $expense = $request->input("expense");
        foreach (json_decode($expense) as $x) {
            $index++;
            Expense::create(["type" => $x->type, "amount" => $x->amount]);
            if (count(json_decode($expense)) == $index) {
                return 1;
            }
        }
    }

    public function delete_record_expense(Request $request)
    {
        $id = $request->input("expenseid");
        $type = $request->input("type");
        Expense::where("id", $id)->delete();
        Log::create(["description" => $type." expenses has been removed at ".date('l jS \of F Y h:i:s A')]);
    }

    public function load_logs()
    {
        return Log::select("description")->selectRaw("CONCAT(SUBSTRING(DAYNAME(created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(created_at), 1, 3), ' ', DAY(created_at), ', ', YEAR(created_at), ' ', TIME_FORMAT(TIME(created_at), '%h:%i:%s %p')) as datetime")->orderBy("created_at", "desc")->get();
    }

    public function delete_record_stock_delivery(Request $request)
    {
        $productid = $request->input("productid");
        $stockid = $request->input("stockid");
        $barcode = $request->input("barcode");
        $batchid = Item_batch::select("id")->where("stockId", $stockid)->get();
        $count = Stock_log::where("productId", $productid)->count();
        Bad_order::where("batchId", $batchid[0]->id)->delete();
        if ($count == 1) {
            Item_batch::where("stockId", $stockid)->delete();
            sleep(0.5);
            Stock_log::where("id", $stockid)->delete();
            sleep(0.5);
            Product::where("id", $productid)->delete();
        } else {
            Item_batch::where("stockId", $stockid)->delete();
            sleep(0.5);
            Stock_log::where("id", $stockid)->delete();
        }
        Log::create(["description" => $barcode." stocks has been removed at ".date('l jS \of F Y h:i:s A')]);
    }

    public function delete_record_bad_order(Request $request)
    {
        $id = $request->input("id");
        $batchid = $request->input("batchid");
        $deduct = $request->input("deduct");
        Bad_order::where("id", $id)->delete();
        $stock = Item_batch::select("quantity")->where("id", $batchid)->get();
        Item_batch::where("id", $batchid)->update(["quantity" => ($deduct + $stock[0]->quantity)]);
    }

    public function search_name_unpaid(Request $request)
    {
        $search = $request->input("search");
        return Purchase::select("type", "orderId", "cashierName", "price", "quantity", "vat", "customerName")->selectRaw("SUM((price - (price * discounts)) * quantity) as total")->selectRaw("CONCAT(SUBSTRING(DAYNAME(created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(created_at), 1, 3), ' ', DAY(created_at), ', ', YEAR(created_at)) as date")->selectRaw("TIME_FORMAT(TIME(created_at), '%h:%i %p') as time")->where("customerName", "like", "%".$search."%")->where("type", "storecredit")->where("status", "unpaid")->groupBy("orderId")->orderBy("created_at", "desc")->get();
    }

    public function search_name_paid(Request $request)
    {
        $search = $request->input("search");
        return Purchase::select("type", "orderId", "cashierName", "price", "quantity", "vat", "customerName")->selectRaw("SUM((price - (price * discounts)) * quantity) as total")->selectRaw("CONCAT(SUBSTRING(DAYNAME(created_at), 1, 3), ', ', SUBSTRING(MONTHNAME(created_at), 1, 3), ' ', DAY(created_at), ', ', YEAR(created_at)) as date")->selectRaw("TIME_FORMAT(TIME(created_at), '%h:%i %p') as time")->where("customerName", "like", "%".$search."%")->where("type", "storecredit")->where("status", "paid")->groupBy("orderId")->orderBy("created_at", "desc")->get();
    }
}
