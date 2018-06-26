<div ng-controller="PromotionController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm mã giảm giá</div>
    <div class="loading"></div>
    <table id="promotionTable" class="table table-hover" st-table="promotionCollection" st-safe-src="promotionInfo" hidden>
        <thead>
            <tr>
                <th st-sort="code">Mã giảm giá</th>
                <th st-sort="benefit">% giảm giá</th>
                <th st-sort="name">Khóa học áp dụng</th>
                <th>Số lượng</th>
                <th st-sort="start_date">Ngày bắt đầu</th>
                <th st-sort="end_date">Ngày kết thúc</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="code" placeholder="Tìm theo Mã" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="benefit" placeholder="Tìm theo % giảm giá" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="name" placeholder="Tìm theo Khóa học" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in promotionCollection">
                <td><% x.code %></td>
                <td><% x.benefit %></td>
                <td><% x.name %></td>
                <td><% x.used %> / <% x.limited %></td>
                <td><% x.start_date | date: "dd/MM/y" %></td>
                <td><% x.end_date | date: "dd/MM/y" %></td>
                <td class="action">
                    <a id='edit' ng-click="showModal(2, x.code)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="delete(x.code)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_promotion_modal')
</div>