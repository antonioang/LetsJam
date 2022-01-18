

<div th:fragment="userCard (user)">
    <div class="user-card fadeInUp mb-4">
        <div class="d-flex flex-row align-items-center justify-content-between mb-2">
            <h3 th:text="${user.firstname} + ' ' + ${user.lastname}"></h3>
            <div id="deleteUser" th:data-user="${user.id}" th:data-username="${user.firstname} + ' ' + ${user.lastname}" class="icon">
                <p th:text="#{admin.manageUsers.delete}"></p>
                <svg th:replace="fragments/icons :: trash"></svg>
                <i></i>
            </div>
        </div>
        <div class="d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex align-items-center justify-content-between mt-2" style="gap:10px;">
                <div class="avatar">
                    &nbsp;
                </div>
                <p th:text="${user.username}" class="mt-1"style="margin:0; text-transform: capitalize;"></p>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-2" style="gap:10px;">
                <p  class="mt-1" style="margin:0;">ruolo attuale</p>
                <p th:text="${user.getRole()}" class="mt-1"style="margin:0; text-transform: capitalize;"></p>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-end" style="gap:20px">
                <div id="promoteUser" th:data-user="${user.id}" th:data-username="${user.firstname} + ' ' + ${user.lastname}" class="icon">
                    <p th:text="#{admin.manageUsers.promote}"></p>
                    <svg  th:replace="fragments/icons :: promote"></svg>
                    <i></i>
                </div>
            </div>
        </div>

    </div>
</div>
