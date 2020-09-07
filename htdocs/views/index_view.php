<?php
require('./views/parts/html_head.php');
?>
<body>
    <?php
    require('./views/parts/nav_menu.php');
    ?>
    <div id="content">
        <div id="left">
            <div class="left-up row">
                <?php
                require('./views/parts/calendar_top.php');
                ?>
                <div class="clock-outer col s6">
                    <div class="clock-inner">
                        <p class="clock_date"><span id="clock_year"></span>年<span id="clock_month"></span>月<span id="clock_day"></span>日 <span id="clock_week"></span>曜日</p>
                        <p class="clock_time"><span id="clock_hour"></span>:<span id="clock_min"></span><span id="clock_sec"></span></p>
                        <!-- <%-- デバッグ用 --%> -->
                    </div>
                </div>
            </div>


            <div class="left-down row">
                <div class="col s12">
                    <h5 class="green-title">タスク管理</h5>
                </div>

                <a class="waves-effect waves-light modal-trigger col s6" href="#new-task-modal">
                    <div id="top-new-task" class="waves-effect waves-light hoverable">
                        <div class="top-new-task-inner">
                            <i class="far fa-calendar-plus fa-6x"></i><br> 新規タスク
                        </div>
                    </div>
                </a>

                <a class="waves-effect waves-light modal-trigger col s6" href="#all-task-modal">
                    <div id="top-all-task" class="waves-effect waves-light hoverable">
                        <div class="top-all-task-inner">
                            <i class="fas fa-tasks fa-3x"></i><br> すべての未完タスク
                        </div>
                    </div>
                </a>

                <a class="waves-effect waves-light modal-trigger col s6" href="#schedule-modal">
                    <div id="top-edit-class" class="waves-effect waves-light hoverable">
                        <div class="top-edit-class-inner">
                            <i class="fas fa-chalkboard fa-3x"></i><br> 時間割の確認・管理
                        </div>
                    </div>
                </a>

            </div>
        </div>


    <!-- 以下、ビュー -->
        <div id="right">
            <div class="row">
                <div class="col s12">
                    <h5 class="orange-title">ビュー</h5>
                    <ul class="tabs">
                        <li class="tab col s3"><a class="active" href="#multi-view">マルチ</a></li>
                        <li class="tab col s3"><a href="#schedule-view">スケジュール</a></li>
                        <li class="tab col s3"><a href="#task-view">タスク</a></li>
                        <li class="tab col s3"><a href="#year-view">年間予定</a></li>
                    </ul>
                </div>
                <div id="multi-view" class="col s12">
                    <div class="row">
                        <div class="col s6">
                            <div class="col s8">
                                <h6 class="green-title">スケジュール</h6>
                            </div>
                            <div class="col s4">
                                <a class="btn-flat grey lighten-2 waves-effect waves-orange modal-trigger" href="#exchange_subject-modal" style="margin-top:5%;margin-left: auto;margin-right: 5px;"><i class="fas fa-exchange-alt"></i> 振替</a>
                            </div>

                            <!-- ここに時間割をのせる -->
                            <% if(now_season >= 0){ %>
                                <%
                                if(today_e == 6){
                                    // 日曜日の場合
                                %>
                                    <p>今日の授業はありません</p>
                                <%}else{%>
                                <%for(int row = 0; row < 6; row++){
                                        if(subject_array[now_season][today_exchange][row].equals("空きコマ")){
                                %>
                                <div class="view-card-empty">
                                <%}else{%>
                                <a class="modal-trigger table-card-a" href="#subject-detail-modal" onclick="selected_Subject_edit(<%= Subject_id_array[now_season][today_exchange][row] %>, '<%= subject_array[now_season][today_exchange][row] %>', '<%= today_full %>', <%= row+1 %>)">
                                <div class="view-card lighten-1 waves-effect waves">
                                <%}%>
                                    <div class="view-num"><%= row+1 %></div>
                                    <%
                                    if(subject_array[now_season][today_exchange][row].equals("空きコマ")){ %>
                                        <span class="view-color-empty"></span>
                                    <%}else{%>
                                        <span class="view-color <%=color_array[now_season][today_exchange][row]%>"></span>
                                    <%}%>
                                    <span class="view-data">
                                        <div class="view-subject"><%=subject_array[now_season][today_exchange][row]%></div>
                                        <div class="view-subject-task-empty red-text"></div>
                                        <div class="view-subject-data"><%=period_section[row]%></div>
                                    </span>
                                    <span class="view-classroom"><%=classroom_array[now_season][today_exchange][row]%></span>
                                </div>
                                <%
                                    if(subject_array[now_season][today_exchange][row].equals("空きコマ")){}else{ %>
                                </a>
                                <%}
                                }
                                }%>
                            <% }else{ %>
                                <p>現在の期間の授業はありません</p>
                            <% } %>
                        </div>
                        <div class="col s6">
                            <h6 class="orange-title">タスク</h6>
                            <!-- ココにタスク -->
                            <% if(task_count >= 6){ %>
                                <% for(int i = 0; i < 6; i++){%>
                                    <a class="modal-trigger table-card-a" href="#task-detail-modal" onclick="selected_task(<%=task_id[i]%>, '<%=taskname[i]%>', '<%=task_deadline[i]%>', <%=task_period[i]%>, <%=task_priority[i]%>, '<%=task_memo[i]%>')">
                                        <div class="view-card lighten-1 waves-effect waves-<%= task_priority_color[task_priority[i]-1] %>">
                                            <span class="view-color <%= task_priority_color[task_priority[i]-1] %>"></span>
                                            <span class="view-data">
                                                <div class="view-subject"><%= taskname[i] %></div>
                                                <div class="view-subject-task-empty red-text"></div>
                                                <div class="view-subject-data">- <%= task_deadline[i] %> <%= task_period[i] %>限</div>
                                            </span>
                                        </div>
                                    </a>
                                <% } %>
                            <% }else if(taskname[0].equals("-1")){ %>
                                    <p>タスクはありません</p>
                            <% }else{ %>
                                <% for(int i = 0; i < task_count ; i++){ %>
                                    <a class="modal-trigger table-card-a" href="#task-detail-modal" onclick="selected_task(<%=task_id[i]%>, '<%=taskname[i]%>', '<%=task_deadline[i]%>', <%=task_period[i]%>, <%=task_priority[i]%>, '<%=task_memo[i]%>')">
                                        <div class="view-card lighten-1 waves-effect waves-<%= task_priority_color[task_priority[i]-1] %>">
                                            <span class="view-color <%= task_priority_color[task_priority[i]-1] %>"></span>
                                            <span class="view-data">
                                                <div class="view-subject"><%= taskname[i] %></div>
                                                <div class="view-subject-task-empty red-text"></div>
                                                <div class="view-subject-data">- <%= task_deadline[i] %> <%= task_period[i] %>限</div>
                                            </span>
                                        </div>
                                    </a>
                                <% } %>
                            <% } %>
                        </div>
                    </div>
                </div>

                <div id="schedule-view" class="col s12">
                    <div class="row">
                        <div class="col s6">
                            <h6 class="green-title">スケジュール(今日)</h6>

                            <!-- ここに時間割をのせる -->
                            <% if(now_season >= 0){ %>
                            <%
                            if(today_e == 6){
                                // 日曜日の場合
                            %>
                                <p>今日の授業はありません</p>
                            <%}else{%>
                            <%    for(int row = 0; row < 6; row++){
                                    if(subject_array[now_season][today_exchange][row].equals("空きコマ")){ 
                            %>
                            <div class="view-card-empty">
                            <%}else{%>
                            <a class="modal-trigger table-card-a" href="#subject-detail-modal" onclick="selected_Subject_edit(<%= Subject_id_array[now_season][today_exchange][row] %>, '<%= subject_array[now_season][today_exchange][row] %>', '<%= today_full %>', <%= row+1 %>)">
                            <div class="view-card lighten-1 waves-effect waves">
                            <%}%>
                                <div class="view-num"><%= row+1 %></div>
                                <%
                                if(subject_array[now_season][today_exchange][row].equals("空きコマ")){ %>
                                    <span class="view-color-empty"></span>
                                <%}else{%>
                                    <span class="view-color <%=color_array[now_season][today_exchange][row]%>"></span>
                                <%}%>
                                <span class="view-data">
                                    <div class="view-subject"><%=subject_array[now_season][today_exchange][row]%></div>
                                    <div class="view-subject-task-empty red-text"></div>
                                    <div class="view-subject-data"><%=period_section[row]%></div>
                                </span>
                                <span class="view-classroom"><%=classroom_array[now_season][today_exchange][row]%></span>
                            </div>
                            <%
                                if(subject_array[now_season][today_exchange][row].equals("空きコマ")){}else{ %>
                            </a>
                            <%}
                            }
                            }%>
                            <% }else{ %>
                                <p>現在の期間の授業はありません</p>
                            <% } %>
                        </div>
                        <div class="col s6">
                            <h6 class="orange-title">次の授業日</h6>

                            <!-- ここに時間割をのせる -->
                            <% if(now_season >= 0){ %>
                            <%for(int row = 0; row < 6; row++){
                                    if(subject_array[now_season][nextday_exchange][row].equals("空きコマ")){
                            %>
                            <div class="view-card-empty">
                            <%}else{%>
                            <a class="modal-trigger table-card-a" href="#subject-detail-modal" onclick="selected_Subject_edit(<%= Subject_id_array[now_season][nextday_exchange][row] %>, '<%= subject_array[now_season][nextday_exchange][row] %>', '<%= next_day %>', <%= row+1 %>)">
                            <div class="view-card lighten-1 waves-effect waves">
                            <%}%>
                                <div class="view-num"><%= row+1 %></div>
                                <%
                                if(subject_array[now_season][nextday_exchange][row].equals("空きコマ")){ %>
                                    <span class="view-color-empty"></span>
                                <%}else{%>
                                    <span class="view-color <%=color_array[now_season][nextday_exchange][row]%>"></span>
                                <%}%>
                                <span class="view-data">
                                    <div class="view-subject"><%=subject_array[now_season][nextday_exchange][row]%></div>
                                    <div class="view-subject-task-empty red-text"></div>
                                    <div class="view-subject-data"><%=period_section[row]%></div>
                                </span>
                                <span class="view-classroom"><%=classroom_array[now_season][nextday_exchange][row]%></span>
                            </div>
                            <%
                                if(subject_array[now_season][nextday_exchange][row].equals("空きコマ")){}else{ %>
                            </a>
                            <%}
                            }%>
                            <% }else{ %>
                                <p>現在の期間の授業はありません</p>
                            <% } %>
                        </div>
                    </div>
                </div>
                <div id="task-view" class="col s12">
                    <div class="row">
                        <div class="col s12">
                            <h6 class="orange-title">タスク</h6>
                        </div>
                        <div class="col s6">
                            <!-- ココにタスク -->
                            <% if(task_count >= 6){ %>
                                <% for(int i = 0; i < 6; i++){%>
                                    <a class="modal-trigger table-card-a" href="#task-detail-modal" onclick="selected_task(<%=task_id[i]%>, '<%=taskname[i]%>', '<%=task_deadline[i]%>', <%=task_period[i]%>, <%=task_priority[i]%>, '<%=task_memo[i]%>')">
                                        <div class="view-card lighten-1 waves-effect waves-<%= task_priority_color[task_priority[i]-1] %>">
                                            <span class="view-color <%= task_priority_color[task_priority[i]-1] %>"></span>
                                            <span class="view-data">
                                                <div class="view-subject"><%= taskname[i] %></div>
                                                <div class="view-subject-task-empty red-text"></div>
                                                <div class="view-subject-data">- <%= task_deadline[i] %> <%= task_period[i] %>限</div>
                                            </span>
                                        </div>
                                    </a>
                                <% } %>
                            <% }else if(taskname[0].equals("-1")){ %>
                                    <p>タスクはありません</p>
                            <% }else{ %>
                                <% for(int i = 0; i < task_count ; i++){ %>
                                    <a class="modal-trigger table-card-a" href="#task-detail-modal" onclick="selected_task(<%=task_id[i]%>, '<%=taskname[i]%>', '<%=task_deadline[i]%>', <%=task_period[i]%>, <%=task_priority[i]%>, '<%=task_memo[i]%>')">
                                        <div class="view-card lighten-1 waves-effect waves-<%= task_priority_color[task_priority[i]-1] %>">
                                            <span class="view-color <%= task_priority_color[task_priority[i]-1] %>"></span>
                                            <span class="view-data">
                                                <div class="view-subject"><%= taskname[i] %></div>
                                                <div class="view-subject-task-empty red-text"></div>
                                                <div class="view-subject-data">- <%= task_deadline[i] %> <%= task_period[i] %>限</div>
                                            </span>
                                        </div>
                                    </a>
                                <% } %>
                            <% } %>
                        </div>
                        <div class="col s6">
                            <!-- ココにタスク -->
                            <% if(task_count - 6 >= 6){ %>
                                <% for(int i = 6; i < 12; i++){%>
                                    <a class="modal-trigger table-card-a" href="#task-detail-modal" onclick="selected_task(<%=task_id[i]%>, '<%=taskname[i]%>', '<%=task_deadline[i]%>', <%=task_period[i]%>, <%=task_priority[i]%>, '<%=task_memo[i]%>')">
                                        <div class="view-card lighten-1 waves-effect waves-<%= task_priority_color[task_priority[i]-1] %>">
                                            <span class="view-color <%= task_priority_color[task_priority[i]-1] %>"></span>
                                            <span class="view-data">
                                                <div class="view-subject"><%= taskname[i] %></div>
                                                <div class="view-subject-task-empty red-text"></div>
                                                <div class="view-subject-data">- <%= task_deadline[i] %> <%= task_period[i] %>限</div>
                                            </span>
                                        </div>
                                    </a>
                                <% } %>
                            <% }else if(task_count - 6 < 5 && task_count - 6 > 0){ %>
                                <% for(int i = 6; i < task_count ; i++){ %>
                                    <a class="modal-trigger table-card-a" href="#task-detail-modal" onclick="selected_task(<%=task_id[i]%>, '<%=taskname[i]%>', '<%=task_deadline[i]%>', <%=task_period[i]%>, <%=task_priority[i]%>, '<%=task_memo[i]%>')">
                                        <div class="view-card lighten-1 waves-effect waves-<%= task_priority_color[task_priority[i]-1] %>">
                                            <span class="view-color <%= task_priority_color[task_priority[i]-1] %>"></span>
                                            <span class="view-data">
                                                <div class="view-subject"><%= taskname[i] %></div>
                                                <div class="view-subject-task-empty red-text"></div>
                                                <div class="view-subject-data">- <%= task_deadline[i] %> <%= task_period[i] %>限</div>
                                            </span>
                                        </div>
                                    </a>
                                <% } %>
                            <% } %>
                        </div>
                    </div>
                </div>
                <div id="year-view" class="col s12">
                    <div class="row">
                        <div class="col s6">
                            <h6 class="blue-title">前期</h6>

                            <div class="card blue-grey lighten-4">
                                <div class="card-content">
                                    <span class="card-title">授業期間</span>
                                    <p class="card-p"><strong><%= season1_start_day_str %> - <%= season1_end_day_str %></strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col s6">
                            <h6 class="blue-title">後期</h6>

                            <div class="card blue-grey lighten-4">
                                <div class="card-content">
                                    <span class="card-title">授業期間</span>
                                    <p class="card-p"><strong><%= season2_start_day_str %> - <%= season2_end_day_str %></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <%@ include file="modals/new_task.jsp" %>

    <%@ include file="modals/all_task.jsp" %>

    <%@ include file="modals/schedule.jsp" %>

    <%@ include file="modals/task_detail.jsp" %>

    <%@ include file="modals/edit_subject.jsp" %>

    <%@ include file="modals/subject_detail.jsp" %>

    <%@ include file="modals/exchange_subject.jsp" %>
</body>

<script src="./JS/show_hide.js"></script>
</html>