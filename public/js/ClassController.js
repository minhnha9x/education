angular.module('educationApp').controller('ClassController', function($scope, $http, $filter) {
    $scope.room_available = {};
    $scope.room_available_render = {};
    $scope.courseList = [];
    $scope.officeList = [];
    $scope.scheduleList = {};
    $scope.teacherScheduleList = {};
    $scope.tempTeacherList = [];
    $scope.teachingList = {};
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
    
    $scope.$watch('list_day_in_week', function() {
        // some value in the array has changed
        $scope.updateStartDate();
    }, true); // watching properties

    $scope.cleanForm = function() {
        $scope.subjectSelected = undefined;
        $scope.courseList = [];
        $scope.officeList = [];
        $scope.startDate = undefined;
        $scope.list_day_in_week = {
            "Monday":false,
            "Tuesday":false,
            "Wednesday":false,
            "Thursday":false,
            "Friday":false,
            "Saturday":false,
            "Sunday":false
        };
        $scope.supervisorSelected = undefined;
        $scope.endDate = undefined;
    }

    $scope.checkAddingClass = function() {
        if ($scope.subjectSelected && 
            $scope.courseSelected && 
            $scope.officeSelected && 
            $scope.startDate && 
            $scope.endDate && 
            $scope.supervisorSelected) {
            return false;
        }
        return true;
    }

    $scope.showModal = function(param1, param2) {
        $scope.cellIdSelected = param1 + '_' + param2;
        $scope.room_in_cell = null;
        $scope.teacher_in_cell = null;
        for (var i in $scope.TAList) {
          $scope.TAList[i].TASelected = null;
        }

        if ($scope.cellIdSelected in $scope.scheduleList){
            $scope.room_in_cell = $scope.scheduleList[$scope.cellIdSelected][0];
            $scope.teacher_in_cell = $scope.scheduleList[$scope.cellIdSelected][1];
            $scope.TAList = $scope.scheduleList[$scope.cellIdSelected][2];
        }

        $scope.tempTeacherList = $scope.checkEmptyTeacher(param1, param2);
        $scope.tempRoomList = $scope.checkEmptyRoom(param1, param2);
        $scope.tempTAList = $scope.checkEmptyTA(param1, param2);
        $('#scheduleClassModal').modal('hide');
        $('#scheduleDetail').modal('show');
    };

    $scope.updateTempTeachingList = function(index, value) {
        var param = $scope.teachingList[index];
        $('[name="teaching"] option[value="'+ param +'"]').show();
        $scope.teachingList[index] = value;
        $('[name="teaching"] option[value="'+ value +'"]').hide();
    }

    $scope.setSelected = function() {
        if ($scope.room_in_cell && $scope.teacher_in_cell && $scope.checkTAList()){
            $scope.setCheckTag($scope.cellIdSelected);
            $scope.setUnCheckTagAll($scope.cellIdSelected);
            return;
        }
        $scope.setUnCheckTag($scope.cellIdSelected);
    }

    $scope.addClass = function() {
        $scope.cleanForm();
        $('#addClassModal').modal('show');
    }

    $scope.checkTAList = function() {
        for (var i in $scope.TAList) {
            if (!($scope.TAList[i].TASelected)) {
                return false;
            };
        }
        return true;
    }

    $scope.backAddClass = function() {
        $('#addClassModal').modal('show');
        $('#scheduleClassModal').modal('hide');
    }

    $scope.addClassDetail = function() {
        $('#addClassModal').modal('hide');
        $('#scheduleClassModal').modal('show');
    }

    $scope.unSelected = function() {
        $scope.room_in_cell = null;
        $scope.teacher_in_cell = null;
        $scope.updateTempTeachingList('main', null);
        for (var i in $scope.TAList) {
          $scope.TAList[i].TASelected = null;
          $scope.updateTempTeachingList('ta_'+i, null);
        }
    };

    $scope.setCheckTag = function(id) {
        $("#" + id).html('<img src="./img/checked.png">');
        $scope.scheduleList[id] = [$scope.room_in_cell, $scope.teacher_in_cell, JSON.parse(JSON.stringify($scope.TAList))];
    };

    $scope.setUnCheckTag = function(id) {
        var res = id.split("_");
        var src = $scope.getSrc(res[0], res[1]);
        $("#" + id).html('<img src="'+ src +'">');
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
    $scope.getSrc = function(slot, day) {
        var tempTeacher = $scope.checkEmptyTeacher(slot, day);
        var tempRoom = $scope.checkEmptyRoom(slot, day);
        var tempTa = $scope.checkEmptyTA(slot, day);
        if (tempTeacher.length == 0 || tempRoom.length == 0 || tempTa.length == 0) {
            return "./img/invalid.png";
        }
        return "./img/uncheck.png";
    };

    $scope.checkEmptyTeacher = function(slot, day) {
        var tempTeacher = [];
        for (var key in $scope.teacherScheduleList) {
            if (!(day in $scope.teacherScheduleList[key].schedule)) {
                tempTeacher.push([key, $scope.teacherScheduleList[key].name]);
            }
            else if ($scope.teacherScheduleList[key].schedule[day].indexOf(parseInt(slot)) == -1) {
                tempTeacher.push([key, $scope.teacherScheduleList[key].name]);
            }
        }
        return tempTeacher;
    };

    $scope.checkEmptyTA = function(slot, day) {
        var tempTeacher = [];
        for (var key in $scope.taScheduleList) {
            if (!(day in $scope.taScheduleList[key].schedule)) {
                tempTeacher.push([key, $scope.taScheduleList[key].name]);
            }
            else if ($scope.taScheduleList[key].schedule[day].indexOf(parseInt(slot)) == -1) {
                tempTeacher.push([key, $scope.taScheduleList[key].name]);
            }
        }
        return tempTeacher;
    };

    $scope.checkEmptyRoom = function(slot, day) {
        var tempRoom = [];
        for (var key in $scope.room_available) {
            if (!(day in $scope.room_available[key])) {
                tempRoom.push(key);
            }
            else if ($scope.room_available[key][day].indexOf(parseInt(slot)) == -1) {
                tempRoom.push(key);
            }
        }
        return tempRoom;
    };

    $scope.courseUpdated = function() {
        $http.get("get_available_office", {params: { course_id: $scope.courseSelected}})
            .then(function(response) {
                $scope.officeList = response.data;
            }, function(x) {
                // Request error
            });
        $scope.updateNumberOfTA();
    };

    $scope.updateNumberOfTA = function() {
        $scope.TAList = [];
        var temp = $scope.courseList.find(x => x.id == $scope.courseSelected);
        if (!temp) {
            $scope.TAList = [];
        }
        else {
            for (var i = 0; i < temp.teaching_assistant; i++) { 
                $scope.TAList[i] = {TASelected:undefined};
            }
        }
    };

    $scope.officeUpdated = function() {
        $http.get("getsupervisors", {params: { office_id: $scope.officeSelected}})
            .then(function(response) {
                $scope.supervisorList = response.data;
            }, function(x) {
                // Request error
            });
    }

    $scope.getTeacherAvailable = function() {
        $http({
            url: './getteacherschedule',
            method: 'GET',
            params: {
                course: $scope.courseSelected,
                office: $scope.officeSelected,
                start_date: $scope.startDate.toDateString(),
                end_date: $scope.endDate.toDateString(),
            },
        })
        .then(function(response) {
            $scope.teacherScheduleList = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }

    $scope.getTAAvailable = function() {
        $http({
            url: './gettaschedule',
            method: 'GET',
            params: {
                course: $scope.courseSelected,
                office: $scope.officeSelected,
                start_date: $scope.startDate.toDateString(),
                end_date: $scope.endDate.toDateString(),
            },
        })
        .then(function(response) {
            $scope.taScheduleList = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }

    $scope.getRoomAvailable = function() {
        $http({
            url: './postroomlist',
            method: 'GET',
            params: {
                course: $scope.courseSelected,
                office: $scope.officeSelected,
                start_date: $scope.startDate.toDateString(),
                end_date: $scope.endDate.toDateString(),
            },
        })
        .then(function(response) {
            $scope.room_available = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }

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
    
    $scope.showScore = function(param) {
        $scope.className = param;
        $http({
            url: './getScore',
            method: 'GET',
            params: {id: param},
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
            $http({
                url: './updateScore',
                method: 'POST',
                params: {
                    id: $scope.scoreInfo[x].id,
                    register: $scope.scoreInfo[x].register,
                    score: $scope.scoreInfo[x].score,
                },
            })
            .then(function(response) {
                
            }, function(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
        }
    }

    $scope.subjectUpdated = function() {
        $scope.courseList = [];
        $http({
            url: './getCourseFromSub',
            method: 'GET',
            params: {id: $scope.subjectSelected},
        })
        .then(function(response) {
            $scope.courseList = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.updateStartDate = function() {
        var newTemp = $filter("filter")($scope.courseList, {id:$scope.courseSelected});
        var daysInWeek = $scope.getSelectedDayList().length;
        if (newTemp.length > 0 && daysInWeek > 0) {
            var count = Math.round(newTemp[0].total_of_period/daysInWeek) + 2;
            $scope.endDate = new Date($scope.startDate)
            $scope.endDate.setDate($scope.endDate.getDate() + count*7);
        }
        else {
            $scope.endDate = undefined;
        }
    };

    $scope.getSelectedDayList = function() {
        var checkedList = [];
        for (var key in $scope.list_day_in_week) {
            if ($scope.list_day_in_week[key] == true) {
                checkedList.push(key);
            }
        }
        return checkedList;
    };
    $scope.checkFillFull = function() {
        if ($scope.scheduleList) {
            return Object.keys($scope.scheduleList).length!=$scope.getSelectedDayList().length;
        }
        return true;
    }
    $scope.storeClass = function() {
        $http({
            url: './addclass',
            method: 'POST',
            data: {
                subject: $scope.subjectSelected,
                course: $scope.courseSelected,
                office: $scope.officeSelected,
                start_date: $scope.startDate.toDateString(),
                end_date: $scope.endDate.toDateString(),
                days: $scope.getSelectedDayList(),
                supervisor: $scope.supervisorSelected,
                schedule: $scope.scheduleList
            },
        })
        .then(function(response) {
            location.reload();
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
});
