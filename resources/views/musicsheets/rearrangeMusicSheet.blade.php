<html
    xmlns:layout="http://www.ultraq.net.nz/thymeleaf/layout"
    xmlns:th="http://www.thymeleaf.org"
    xmlns:nl2br="https://github.com/bufferings/thymeleaf-extras-nl2br"
    layout:decorate="~{layout/layout}">
<head>
    <script src="https://prod.flat-cdn.com/embed-js/v1.1.0/embed.min.js"></script>
    <link rel="stylesheet" type="text/css" th:href="@{/css/create-upload.css}">
    <script type="text/javascript" th:src="@{/js/rearrangeMusicSheet.js}"></script>
    <script th:inline="javascript">
        /*<![CDATA[*/
        var musicSheetData = /*[[${musicSheetData}]]*/ '';
        var musicSheet = /*[[${musicSheet}]]*/'';
        /*]]>*/
    </script>
</head>
<body>
<div layout:fragment="content" style="padding-top:90px">
    <section id="flat-wrap" class="flat-wrap">
        <div class="flat-inner-wrap">
            <div id="create" class="flat-part-left mr-4">
                <h2 th:text="#{rearrange.title}"></h2>
                <form id="createForm" th:action="@{/musicsheets/rearrange}" method="post" th:object="${pageData}" enctype="multipart/form-data" style="width:100%">
                    <div class="sheet-info">
                        <label name="title" th:inline="text">
                            [[#{rearrange.musicsheet.title}]]
                            <input th:field="${pageData.title}" id="sheet-title" type="text"/>
                        </label>
                        <label name="author" th:inline="text">
                            [[#{rearrange.musicsheet.author}]]
                            <input th:field="${pageData.author}" id="sheet-author" name="title" type="text" required/>
                        </label>

                        <div class="button wow fadeInUp submit mt-4" data-wow-delay=".7s"
                             style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp; width: fit-content; display:none">
                            <a id="check-instrument" class="btn" th:text="#{rearrange.musicsheet.check.instrument}"></a>
                        </div>

                        <div class="d-flex flex-column align-items-start mt-3">
                            <label name="visibility" class="mb-0" th:text="#{rearrange.musicsheet.visibility}"></label>
                            <div class="btn-group btn-group-toggle visibilityToggle" data-toggle="buttons">
                                <label class="btn btn-primary active" th:inline="text">
                                    [[#{rearrange.musicsheet.visibility.private}]]
                                    <input type="radio" name="musicSheetVisibility" id="option1" value="0" autocomplete="off" checked>
                                </label>
                                <label class="btn btn-primary" th:inline="text">
                                    [[#{rearrange.musicsheet.visibility.public}]]
                                    <input type="radio" name="musicSheetVisibility" id="option2" autocomplete="off"  value="1">
                                </label>
                            </div>
                        </div>

                        <input id="musicSheetContent" th:field="${pageData.content}" type="hidden">
                        <input id="visibility" th:field="${pageData.visibility}" type="hidden" />

                        <div id="rearrange-submit" class="button wow fadeInUp submit mt-4" data-wow-delay=".7s"
                             style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp; width: fit-content;">
                            <a class="btn" th:text="#{rearrange.rearrange}"></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flat-part-right">
                <div id="embed-example"></div>
            </div>
        </div>
    </section>
</div>
</body>
</html>
