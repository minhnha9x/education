angular.module('educationApp').controller('ClassController', function($scope, $http) {
    $scope.room_available = {};
    $scope.room_available_render = {};
    $scope.courseList = {};
    $scope.officeList = [];
    $scope.scheduleList = {};
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
        $scope.cellIdSelected = param1 + '_' + param2;
        $scope.room_in_cell = null;
        $scope.teacher_in_cell = null;
        $scope.ta_in_cell = null;
        if ($scope.cellIdSelected in $scope.scheduleList){
            $scope.room_in_cell = $scope.scheduleList[$scope.cellIdSelected][0];
            $scope.teacher_in_cell = $scope.scheduleList[$scope.cellIdSelected][1];
            $scope.ta_in_cell = $scope.scheduleList[$scope.cellIdSelected][2];
        }
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

    $scope.unSelected = function() {
        $scope.room_in_cell = null;
        $scope.teacher_in_cell = null;
        $scope.ta_in_cell = null;
    };

    $scope.setCheckTag = function(id) {
        $("#" + id).html('<img src="./img/check.png">');
        $scope.scheduleList[id] = [$scope.room_in_cell, $scope.teacher_in_cell, $scope.ta_in_cell];
    };

    $scope.setUnCheckTag = function(id) {
        $("#" + id).html('<img src="./img/cross.png">');
        delete $scope.scheduleList[id];
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
        $http.get("get_available_office", {params: { course_id: $scope.courseSelected}})
            .then(function(response) {
                $scope.officeList = response.data;
                $scope.officeSelected = $scope.officeList[0]['id'].toString();
                $scope.officeUpdated();
            }, function(x) {
                // Request error
            });
    };

    $scope.officeUpdated = function() {
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
        $scope.scheduleList = {};
        for (var key in $scope.list_day_in_week) {
            if ($scope.list_day_in_week[key] == true) {
                $scope.checkedList.push(key);
            }
        }
        for (var index in $scope.checkedList) {
            for (var key in $scope.slot_in_day) {
                $scope.setUnCheckTag(key + '_' + $scope.checkedList[index]);
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
    };
    
    $scope.showScore = function(param) {
        $http({
            url: './getScore',
            method: 'GET',
            params: {id: param},
            headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
        })
        .then(function(response) {
            $scope.scoreInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
        $('#scoreTable').modal('show', 300);
    }

    $scope.updateScore = function() {
        for (var x in $scope.scoreInfo) {
            console.log($scope.scoreInfo[x]);
            $http({
                url: './updateScore',
                method: 'POST',
                params: {
                    id: $scope.scoreInfo[x].id,
                    id: $scope.scoreInfo[x].register,
                    score: $scope.scoreInfo[x].score,
                },
                headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
            })
            .then(function(response) {
            }, function(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
        }
        console.log($scope.scoreInfo);
    }

    $('#addClassModal select[name="subject"]').on('change', function() {
        $scope.courseList = {};
        $('#addClassModal').find('select[name="course"] option:not(:first-child)').remove();
        $.ajax({
            url : "getcoursefromsub" + $(this).val(),
            type : "get",
            dataType:"text",
            success : function (result){
                obj = JSON.parse(result);
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
