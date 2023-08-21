<div style="width:800px;margin:0px auto;border:solid 1px #dbd8d8;padding:5px 20px 5px 20px">
    <div class="adM">
    </div>
    <div style="font-size:14px">
        <div class="adM">
        </div>
        <p style="font-style:italic;font-weight:bold">Cảm ơn Quý khách <span
                style="font-style:normal;color:#067461">{{ $order->customer_name }}</span> đã đặt hàng tại Ismart Store.
        </p>
        <p>Ismart rất vui được thông báo đơn hàng <span style="font-weight:bold">ISM_{{ $orderID }}</span> của Quý
            khách đã
            được tiếp nhận và đang trong quá trình xử lý.
            Ismart sẽ thông báo cho Quý khách khi đơn hàng chuẩn bị giao hàng.</p>
    </div>
    <p style="font-size:18px">THÔNG TIN ĐƠN HÀNG: ISM_{{ $orderID }}</p>
    <hr style="border:solid 1px #dbd8d8">
    <div>
        <table cellpadding="5" cellspacing="0" border="1" width="100%" style="font-size:15px">
            <tbody>
                <tr style="background-color:#20d144;color:#fff">
                    <th> THÔNG TIN ĐƠN HÀNG </th>
                </tr>
                <tr>
                    <td style="vertical-align:top">
                        Người nhận hàng: <strong style="color:#067461">{{ $order->customer_name }}</strong><br>
                        Địa chỉ: <strong>{{ $order->customer_address }}</strong><br>
                        Điện thoại:<strong>{{ $order->customer_phone }}</strong><br>
                        Email:<strong><a href="mailto:thuha250300@gmail.com"
                                target="_blank">{{ $order->customer_email }}</a></strong><br>
                        Thông tin ghi chú:<strong>{{ $order->customer_note }}</strong><br>
                    </td>
                </tr>
            </tbody>
        </table>
        <p>Phương thức thanh toán: <span style="font-weight:bold">{{ $order->status }}</span></p>
        <table cellpadding="5" cellspacing="0"
            style="font-size:15px!important;border:none;table-layout:auto;width:100%">
            <tbody style="background-color:#f5f0f0">
                <tr style="background-color:#0fe93a;color:#fff">
                    <th>SẢN PHẨM</th>
                    <th>GIÁ SẢN PHẨM</th>
                    <th>SỐ LƯỢNG</th>
                    <th>THÀNH TIỀN</th>
                </tr>
                @foreach ($orderDetails as $detail)
                    <tr>
                        <td style="text-align:center;width:35%">{{ $detail['product_name'] }}</td>
                        <td style="text-align:center;width:25%">
                            {{ number_format($detail['product_price'], 0, ',', '.') }}đ</td>
                        <td style="text-align:center;width:15%">{{ $detail['qty'] }}</td>
                        <td style="text-align:center;width:25%">
                            {{ number_format($detail['total_price'], 0, ',', '.') }}đ</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="width:100%;text-align:right;padding:10px 0"><span>Tổng giá trị sản phẩm:
                        </span></td>
                    <td colspan="2" style="width:100%;text-align:right;padding:10px 0"><span
                            style="padding-right:10px;font-weight:bold">{{ number_format($detail['total_sum'], 0, ',', '.') }}đ</span>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div style="width:100%;clear:both;display:block;overflow:hidden;margin:30px 0px 0px">
            <p style="display:block;font-size:14px;color:#333333;margin:0px 0px 5px;line-height:20px"><span
                    style="font-family:Arial,sans-serif">Nếu cần hỗ trợ, Quý khách chỉ cần gửi email đến <a
                        href="mailto:ismart.project.trungdung@gmail.com" target="_blank">thuha250300@gmail.com</a>
                    hoặc gọi số <strong>0988274803</strong>.</span></p>
            <p style="display:block;font-size:14px;color:#333333;margin:0px 0px 5px;line-height:20px">Cảm ơn Quý
                Khách!&nbsp;</p>
            <div class="yj6qo"></div>
            <div class="adL"></div>
            <div class="adL">
            </div>
        </div>
        <div class="adL">
        </div>
    </div>
    <div class="adL">
    </div>
</div>
