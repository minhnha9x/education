var myApp = angular.module('educationApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

myApp.controller('addClassController', function($scope, $http) {
    $scope.room_available = {};
    $scope.room_available_render = {}; 
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

    $scope.log = function() {
        console.log("hihi", $scope.list_day_in_week);
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

    $(document).on('change', '#addClassModal .checkchange', function(e) {
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
                    "course": $('#addClassModal select[name="course"]').val(),
                    "office": $('#addClassModal select[name="office"]').val(),
                    "start_date": $('#addClassModal input[name="start_date"]').val(),
                    "end_date": $('#addClassModal input[name="end_date"]').val(),
                },
                dataType:"text",
                success : function (result){
                    $scope.room_available = JSON.parse(result);
                    $("#room_available").text(Object.keys($scope.room_available).length);
                    console.log("haha", $scope.room_available);
                }
            });
            $('#addClassModal input[name="change"]').prop("disabled", false);
        }
    });

});
