<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-family:'Helvetica'
    }
    table tr td, table tr th{
        border: 1px solid #000000;
        text-align: left;
        padding: 4px;
        font-size: 12px;
    }
    .table-0 tr td, .table-0 tr th{
        border: 0px;
        text-align: center;
        padding: 5px;
        font-size: 12px;
    }
    .bill-table tr td{
        text-align: right;
    }
</style>
<table class="table-0">
    <tr>
        <th style="font-size:20px;padding:0px;"><u>@if(!empty($payHistory[0]->name)) {{ $payHistory[0]->name }} @endif</u></th>
    </tr>
    <tr>
        <td>
            @if(!empty($payHistory[0]->address)) {{ $payHistory[0]->address }} @endif
            @if(!empty($payHistory[0]->city)) {{ ', '.$payHistory[0]->city }} @endif
            @if(!empty($payHistory[0]->pincode)) {{ ', '.$payHistory[0]->pincode }} @endif
            @if(!empty($payHistory[0]->state)) {{ ', '.$payHistory[0]->state }} @endif
            @if(!empty($payHistory[0]->country)) {{ ', '.$payHistory[0]->country }} @endif
        </td>
    </tr>
</table></br>

<h5 style="text-align:center;margin-bottom:4px;line-height:1;font-family:'Helvetica'">TAX INVOICE (MAINTENANCE BILLS)</h5>
<table style="margin-bottom:5px;">
    <tr>
        <th>FLAT/SHOP NO.</th>
        <td>
            @if(!empty($payHistory[0]->ft_no)) {{ $payHistory[0]->ft_no }} @endif
            @if(!empty($payHistory[0]->area)) {{ '  ---Area - '.$payHistory[0]->area.' Sq. Ft.' }} @endif
        </td>
        <th>INVOICE NO.</th>
        <td>@if(!empty($payHistory[0]->billno)) {{ $payHistory[0]->billno }} @endif</td>
    </tr>
    <tr>
        <th>Member Name</th>
        <td>@if(!empty($payHistory[0]->first_name)) {{ $payHistory[0]->first_name }} {{ $payHistory[0]->last_name }} @endif</td>
        <th>INVOICE DATE</th>
        <td>@if(!empty($payHistory[0]->bill_date)) {{ date_format(date_create($payHistory[0]->bill_date),'d M, Y') }} @endif</td>
    </tr>
    <tr>
        <th>For the MONTH</th>
        <td>@if(!empty($payHistory[0]->month)) {{ date_format(date_create($payHistory[0]->month),'F') }} @endif</td>
        <th>DUE DATE</th>
        <td>@if(!empty($payHistory[0]->due_date)) {{ date_format(date_create($payHistory[0]->due_date),'d M, Y') }} @endif</td>
    </tr>
</table>

<table class="bill-table">
    <tr>
        <th>Description of Services</th>
        <th>Amount (INR)</th>
    </tr>
    <tr style="background:#d2d7fe;">
        <th colspan="2" style="text-align:center;">NON TAXABLE ITEMS/BILL OF SUPPLY (PART A)</th>
    </tr>
    <tr>
        <th>Municipal Tax</th>
        <td>@if(!empty($payHistory[0]->mun_tax)) {{ number_format($payHistory[0]->mun_tax,2) }} @endif</td>
    </tr>
    <tr>
        <th>Electricity Charges</th>
        <td>@if(!empty($payHistory[0]->electric)) {{ number_format($payHistory[0]->electric,2) }} @endif</td>
    </tr>
    <tr>
        <th>Water Charges</th>
        <td>@if(!empty($payHistory[0]->water)) {{ number_format($payHistory[0]->water,2) }} @endif</td>
    </tr>
    <tr>
        <th>Total of NON TAXABLE ITEMS/BILL OF SUPPLY (PART A)</th>
        <td>@if(!empty($payHistory[0]->ttl_part_a)) {{ number_format($payHistory[0]->ttl_part_a,2) }} @endif</td>
    </tr>
    <tr style="background:#d2d7fe;">
        <th colspan="2" style="text-align:center;">TAXABLE ITEMS/TAX INVOICE (PART B)</th>
    </tr>
    <tr>
        <th>Maintenance Charges</th>
        <td>@if(!empty($payHistory[0]->maint)) {{ number_format($payHistory[0]->maint,2) }} @endif</td>
    </tr>
    <tr>
        <th>Sinking Fund</th>
        <td>@if(!empty($payHistory[0]->sink)) {{ number_format($payHistory[0]->sink,2) }} @endif</td>
    </tr>
    <tr>
        <th>Parking CHG - 4 Wheeler</th>
        <td>@if(!empty($payHistory[0]->pkg_4w)) {{ number_format($payHistory[0]->pkg_4w,2) }} @endif</td>
    </tr>
    <tr>
        <th>Parking CHG - 2 Wheeler</th>
        <td>@if(!empty($payHistory[0]->pkg_2w)) {{ number_format($payHistory[0]->pkg_2w,2) }} @endif</td>
    </tr>
    <tr>
        <th>Extra Repair Fund.</th>
        <td>@if(!empty($payHistory[0]->ex_repair)) {{ number_format($payHistory[0]->ex_repair,2) }} @endif</td>
    </tr>
    <tr>
        <th>SUB-LET</th>
        <td>@if(!empty($payHistory[0]->sub_let)) {{ number_format($payHistory[0]->sub_let,2) }} @endif</td>
    </tr>
    <tr>
        <th>Major Repair Fund.</th>
        <td>
            @if(!empty($payHistory[0]->major_repair))
            {{ number_format($payHistory[0]->major_repair,2) }}
            @endif
        </td>
    </tr>
    <tr>
        <th>Others Charges</th>
        <td>@if(!empty($payHistory[0]->other_chgs)) {{ number_format($payHistory[0]->other_chgs,2) }} @endif</td>
    </tr>
    <tr>
        <th>Cheque Dishonor Charges</th>
        <td>@if(!empty($payHistory[0]->chq_dis)) {{ number_format($payHistory[0]->chq_dis,2) }} @endif</td>
    </tr>
    <tr>
        <th>Late Payment Charges</th>
        <td>@if(!empty($payHistory[0]->late_payment)) {{ number_format($payHistory[0]->late_payment,2) }} @endif</td>
    </tr>
    <tr>
        <th>Interest on Previous Outstanding**</th>
        <td>@if(!empty($payHistory[0]->intrest)) {{ number_format($payHistory[0]->intrest,2) }} @endif</td>
    </tr>
    <tr>
        <th>Total of NON TAXABLE ITEMS</th>
        <td>@if(!empty($payHistory[0]->ttl_part_b)) {{ number_format($payHistory[0]->ttl_part_b,2) }} @endif</td>
    </tr>
    <tr>
        <th>CGST @9%</th>
        <td>@if(!empty($payHistory[0]->ttl_part_b)) {{ number_format(($payHistory[0]->ttl_part_b*9)/100,2) }} @endif</td>
    </tr>
    <tr>
        <th>SGST @9%</th>
        <td>@if(!empty($payHistory[0]->ttl_part_b)) {{ number_format(($payHistory[0]->ttl_part_b*9)/100,2) }} @endif</td>
    </tr>
    <tr>
        <th>Total including GST (PART B)</th>
        <td>@if(!empty($payHistory[0]->ttl_part_b)) {{ number_format(($payHistory[0]->ttl_part_b)+(($payHistory[0]->ttl_part_b*18)/100),2) }} @endif</td>
    </tr>
    <tr style="background:#d2d7fe;">
        <th>Current Bill Amount (PART-A + Part-B)</th>
        <td>@if(!empty($payHistory[0]->ttl_part_b)) {{ number_format($payHistory[0]->ttl_part_a+(($payHistory[0]->ttl_part_b)+(($payHistory[0]->ttl_part_b*18)/100)),2) }} @endif</td>
    </tr>
    <tr>
        <th>Previous Outstanding*</th>
        <td>@if(!empty($payHistory[0]->pod)) 
        {{ number_format($payHistory[0]->pod,2) }}
        @endif</td>
    </tr>
    <tr style="background:#d2d7fe;">>
        <th>Payable Amount (Current Bill Amount + PART C + Previous Outstanding)</th>
        <td>@if(!empty($payHistory[0]->ttl_part_b)) 
            {{ number_format($payHistory[0]->pod+$payHistory[0]->ttl_part_a+(($payHistory[0]->ttl_part_b)+(($payHistory[0]->ttl_part_b*18)/100)),2) }}
         @endif</td>
    </tr>
    <!-- <tr>
        <th colspan="2" style="text-align:center;">TAXABLE ITEMS/TAX INVOICE (PART B)</th>
    </tr> -->
</table>
<p style="text-align:center;font-size:10px;">This is a system generated document and does not require a signature</p>