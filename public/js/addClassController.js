var myApp = angular.module('educationApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

myApp.controller('addClassController', function($scope, $http) {
    $scope.room_available = {};
    $scope.room_available_render = {};
    $scope.courseList = {};
    $scope.officeList = [];
    $scope.list_day_in_week = {
        "Monday":true,
        "Tuesday":false,
        "Wednesday":false,
        "Thursday":false,
        "Friday":false,
        "Saturday":false,
        "Sunday":false
    }

    $scope.slot_in_day = {
        1:"07:00 - 09:00",
        2:"09:00 - 11:00",
        3:"13:00 - 15:00",
        4:"15:00 - 17:00",
        5:"17:00 - 19:00",
        6:"19:00 - 21:00",
    }

    $scope.showModal = function(param1, param2) {
        $scope.room_in_cell = null;
        $scope.teacher_in_cell = null;
        $scope.ta_in_cell = null;
        $scope.cellIdSelected = param1 + '_' + param2;
        $('#scheduleClassModal').modal('hide');
        $('#scheduleDetail').modal('show');
    };

    $scope.setSelected = function() {
        if ($scope.room_in_cell && $scope.teacher_in_cell && $scope.ta_in_cell){
            $scope.setCheckTag($scope.cellIdSelected);
            $scope.setUnCheckTagAll($scope.cellIdSelected);
            return;
        }
        $scope.setUnCheckTag($scope.cellIdSelected);

    };

    $scope.setCheckTag = function(id) {
        $("#" + id).html("&#9989;");
    };

    $scope.setUnCheckTag = function(id) {
        $("#" + id).html("&#10060;");
    };

    $scope.setUnCheckTagAll = function(id) {
        var res = id.split("_");
        for (i = 1; i < 7; i++) {
            var cellId = String(i) + '_' + res[1];
            if (cellId != id){
                $scope.setUnCheckTag(cellId);
            }
        }
    };


    $scope.courseUpdated = function() {
        console.log("hoho", $scope.courseSelected);
        $http.get("get_available_office", {params: { course_id: $scope.courseSelected}})
            .then(function(response) {
                console.log(response.data);
                $scope.officeList = response.data;
                $scope.officeSelected = $scope.officeList[0]['id'].toString();
                $scope.officeUpdated();
            }, function(x) {
                // Request error
            });
    };

    $scope.officeUpdated = function() {
        console.log("hihi", $scope.officeSelected);

        if ($('#addClassModal select[name="subject"]').val() != null 
        && $('#addClassModal select[name="course"]').val() != null 
        && $('#addClassModal select[name="office"]').val() != null 
        && $('#addClassModal input[name="start_date"]').val() != "" 
        && $('#addClassModal input[name="end_date"]').val() != "") {
            $.ajax({
                url : "postroomlist",
                type : "get",
                data : {
                    "subject": $('#addClassModal select[name="subject"]').val(),
                    "course": $scope.courseSelected,
                    "office": $scope.officeSelected,
                    "start_date": $('#addClassModal input[name="start_date"]').val(),
                    "end_date": $('#addClassModal input[name="end_date"]').val(),
                },
                dataType:"text",
                success : function (result){
                    $scope.room_available = JSON.parse(result);
                    $("#room_available").text(Object.keys($scope.room_available).length);
                    console.log("haha", $scope.room_available);
                    if (Object.keys($scope.room_available).length == 0){
                        $('#addClassModal input[name="change"]').prop("disabled", true);
                    }
                    else {
                        $('#addClassModal input[name="change"]').prop("disabled", false);
                    }
                }
            });
        }
    };

    $scope.getCheckedList = function() {
        $scope.checkedList = [];
        for (var key in $scope.list_day_in_week) {
            if ($scope.list_day_in_week[key] == true) {
                $scope.checkedList.push(key);
            }
        }
    };

    $scope.getRoomAvailableList = function() {
        $scope.room_available_render = {};
        for (var room_id in $scope.room_available) {
            $scope.room_available_render[room_id] = {};
            for (var index in $scope.checkedList) {
                day_in_week = $scope.checkedList[index];
                $scope.room_available_render[room_id][day_in_week] = Object.assign({}, $scope.slot_in_day);
                if (day_in_week in $scope.room_available[room_id]) {
                    for (var slot in $scope.room_available[room_id][day_in_week]) {
                        slot_in_day = $scope.room_available[room_id][day_in_week][slot];
                        delete $scope.room_available_render[room_id][day_in_week][slot_in_day];
                    }
                }
            }
        }
        console.log("asda", $scope.room_available_render);
    };

    $('#addClassModal select[name="subject"]').on('change', function() {
        $scope.courseList = {};
        $('#addClassModal').find('select[name="course"] option:not(:first-child)').remove();
        $.ajax({
            url : "getcoursefromsub" + $(this).val(),
            type : "get",
            dataType:"text",
            success : function (result){
                obj = JSON.parse(result);
                console.log("hihi", obj);
                for(var index in obj) { 
                    $scope.courseList[obj[index]['id']] = obj[index]['name'];
                }
                $scope.courseSelected = Object.keys($scope.courseList)[0];
                $scope.$apply();
                $scope.courseUpdated();
            }
        });
    });

});
