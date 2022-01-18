<!DOCTYPE html>
<html xmlns:layout="http://www.ultraq.net.nz/thymeleaf/layout" xmlns:th="http://www.thymeleaf.org"
      layout:decorate="~{layout/layout}">
<head>
    <link rel="stylesheet" type="text/css" th:href="@{css/musicSheetCard.css}">
</head>
<body>
<div layout:fragment="content" th:with="loggedUser=${#authentication.getPrincipal().getUser()}">
    <!-- Start Hero Area -->
    <section class="hero-area" >
        <!-- Single Slider -->
        <div class="hero-inner" style="min-height: calc(100vh - 510px);">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-6 co-12">
                        <div class="home-slider">
                            <div class="hero-text">
                                <h1 th:inline="text">[[#{home.admin.logged.title}]] [[${loggedUser.firstname +' '+loggedUser.lastname}]]</h1>
                                <p class="wow fadeInUp" data-wow-delay=".5s" th:text="#{home.subtitle}"></p>
                                <div class="button wow fadeInUp mb-5" data-wow-delay=".7s">
                                    <a href="about-us.html" class="btn">Per saperne di più</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Single Slider -->
    </section>
</div>
</body>

</html>
