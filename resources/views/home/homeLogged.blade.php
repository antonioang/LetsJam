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
        <div class="hero-inner">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-6 co-12">
                        <div class="home-slider">
                            <div class="hero-text">
                                <h1 th:inline="text">[[#{home.logged.title}]] [[${loggedUser.firstname +' '+loggedUser.lastname}]]</h1>
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
    <!-- Start Service Area -->
    <section class="services section">
        <div class="container">
            <div class="row">
                <div class="col-12 relative">
                    <div class="section-title align-left">
                        <span class="wow fadeInDown" data-wow-delay=".2s" th:text="#{home.mostpopular}"></span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s" th:text="#{home.mostpopular.title}"></h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Crea le tue varianti delle canzoni scritte da te nel nostro editor.
                            Condividi e collabora con migliaia di altri artisti di ogni provenienza uniti soltanto dalla musica.</p>
                    </div>

                    <div th:each="musicsheet : ${mostpopular}">
                        <div th:replace="fragments/musicSheetCard :: musicSheetCard(musicsheet = ${musicsheet})"></div>
                    </div>
                    <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" th:src="@{img/service-patern.png}" alt="#"
                         style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 287px;right: -25px;">
                    <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" th:src="@{img/service-patern.png}" alt="#"
                         style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;bottom: -3px;left: -25px;">
                </div>
            </div>
        </div>
    </section>
    <!-- /End Services Area -->
    <!-- Start random mushicSeet filtered by genre Section -->
    <section class="services section about-us">
        <div class="container">
            <div class="row">
                <div class="col-12 relative">
                    <div class="section-title align-left">
                        <span class="wow fadeInDown" data-wow-delay=".2s" th:text="#{home.musicSheetByGenre}"></span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s" th:text="#{home.musicSheetByGenre.title}"></h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s" th:text="#{home.musicSheetByGenre.description}"></p>
                    </div>

                    <div th:each="musicsheetGenreList : ${musicSheetByGenre}">
                        <div th:if="${musicsheetGenreList.size() > 0}" th:remove="tag">
                            <h3 class="wow fadeInUp genreTitle mt-5 mb-3" data-wow-delay=".4s" th:text="${musicsheetGenreList[0].song.getGenre().getName()}"></h3>
                            <div th:each="musicsheet : ${musicsheetGenreList}">
                                <div th:replace="fragments/musicSheetCard :: musicSheetCard(musicsheet = ${musicsheet})"></div>
                            </div>
                        </div>
                    </div>
                    <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" th:src="@{img/service-patern.png}" alt="#"
                         style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 287px;right: -25px;">
                    <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" th:src="@{img/service-patern.png}" alt="#"
                         style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;bottom: -3px;left: -25px;">
                </div>
            </div>
        </div>
    </section>
    <!-- /End random mushicSeet filtered by genre Section -->
    <!--Last insert-->
    <section class="services section">
        <div class="container">
            <div class="row">
                <div class="col-12 relative">
                    <div class="section-title align-left">
                        <span class="wow fadeInDown" data-wow-delay=".2s" th:text="#{home.lastInsert}"></span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s" th:text="#{home.lastInsert.title}"></h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s" th:text="#{home.mostpopular.description}"></p>
                    </div>

                    <div th:each="musicsheet : ${lastInsert}">
                        <div th:replace="fragments/musicSheetCard :: musicSheetCard(musicsheet = ${musicsheet})"></div>
                    </div>
                    <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" th:src="@{img/service-patern.png}" alt="#"
                         style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;top: 287px;right: -25px;">
                    <img class="service-patern wow fadeInRight overlay-image" data-wow-delay=".5s" th:src="@{img/service-patern.png}" alt="#"
                         style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;position: absolute;bottom: -3px;left: -25px;">
                </div>
            </div>
        </div>
    </section>

</div>
</body>

</html>
