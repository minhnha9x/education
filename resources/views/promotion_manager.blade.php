<div ng-controller="PromotionController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm mã giảm giá</div>
    <div class="loading"></div>
    <table id="promotionTable" class="table table-hover" st-table="promotionCollection" st-safe-src="promotionInfo" hidden>
        <thead>
            <tr>
                <th>Mã giảm giá</th>
                <th>% giảm giá</th>
                <th>Khóa học áp dụng</th>
                <th>Giới hạn</th>
                <th>Đã sử dụng</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="code" placeholder="Tìm theo Mã" class="input-sm form-control" type="search"/></th>
                <th class="search"></th>
                <th class="search"><input st-search="name" placeholder="Tìm theo Khóa học" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in promotionCollection">
                <td><% x.code %></td>
                <td><% x.benefit %></td>
                <td><% x.name %></td>
                <td><% x.limited %></td>
                <td><% x.used %></td>
                <td><% x.start_date %></td>
                <td><% x.end_date %></td>
                <td class="action">
                    <a id='edit' ng-click="showModal(2, x.code)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="delete(x.code)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_promotion_modal')
</div>