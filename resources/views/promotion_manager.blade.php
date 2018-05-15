<div ng-controller="PromotionController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm mã giảm giá</div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Mã giảm giá</th>
                <th>% giảm giá</th>
                <th>Khóa học áp dụng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in promotionInfo">
                <td><% x.code %></td>
                <td><% x.benefit %></td>
                <td><% x.name %></td>
                <td class="action">
                    <a id='edit' ng-click="showModal(2, x.code)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="delete(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_promotion_modal')
</div>