var FavList = "";

function SetDetail(data,status,xhr)
{
	$(".movieDetail").each(function(){
		if ($(this).data("id") == data.id)
		{
			$(this).find("#Rating").text(data.Rating);
			$(this).find("#Genre").text(data.Genre);
			$(this).find("#Director").text(data.Director);
			$(this).find("#Actors").text(data.Actors);
			$(this).find("#Plot").text(data.Plot);
		}
	});
}

function ResetMenu(item)
{
	// TMDB	
	$("#mTNew"   ).text("New").removeClass('selected');
	$("#mTStatus").text("Status").removeClass('selected');
	$("#mTTitle").text("Title").removeClass('selected');
	$("#mTGenre").text("Genre").removeClass('selected');
	$("#mTRating").text("Rating").removeClass('selected');
	$("#mTService").removeClass('selected');
	// XBMC	
	$("#mXDate" ).text("Date").removeClass('selected');
	$("#mXTitle").text("Title").removeClass('selected');
	$("#mXGenre").text("Genre").removeClass('selected');
	$("#mXTag"  ).text("Tag").removeClass('selected');
	$("#mXRating").text("Rating").removeClass('selected');
	$("#mXService").removeClass('selected');
	item.addClass('selected');
}

function SetNavigation(data,status,xhr)
{
	$('#content').html(data);
	$("#spinner").hide();
	$(".cXDate").click(function(){
		$("#mXDate").text($(this).text());
		$("#spinner").show();
		$.post("ListMovie.php",{cXDate:$(this).text()},SetContent);
	});
	$(".cXGenre").click(function(){
		$("#mXGenre").text($(this).text());
		$("#spinner").show();
		$.post("ListMovie.php",{idGenre:$(this).data("id")},SetContent);
	});
	$(".cXTitle").click(function(){
		$("#mXTitle").text($(this).text());
		$("#spinner").show();
		$.post("ListMovie.php",{cXTitle:$(this).text()},SetContent);
	});
	$(".cXTag").click(function(){
		$("#mXTag").text($(this).text());
		$("#spinner").show();
		$.post("ListMovie.php",{idTag:$(this).data("id")},SetContent);
	});
	$(".cXRating").click(function(){
		$("#mXRating").text($(this).text());
		$("#spinner").show();
		$.post("ListMovie.php",{idRating:$(this).data("rating")},SetContent);
	});
	$(".cVStatus").click(function(){
		$("#mTStatus").text($(this).text());
		$("#spinner").show();
		$.post("ListVideo.php",{idStatus:$(this).data("status")},SetContent);
	});
	$(".cVGenre").click(function(){
		$("#mTGenre").text($(this).text());
		$("#spinner").show();
		$.post("ListVideo.php",{cVGenre:$(this).text()},SetContent);
	});
	$(".cVTitle").click(function(){
		$("#mVTitle").text($(this).text());
		$("#spinner").show();
		$.post("ListVideo.php",{cVTitle:$(this).text()},SetContent);
	});
	$(".cVRating").click(function(){
		$("#mTRating").text($(this).text());
		$("#spinner").show();
		$.post("ListVideo.php",{idRating:$(this).data("rating")},SetContent);
	});
	$("#mSPlayed").click(function(){
		window.open("ServicePlayed.php", "_blank");
	});
	$("#mSIndex").click(function(){
		window.open("ServiceIndex.php", "_blank");
	});
	$("#mSDup").click(function(){
		$("#spinner").show();
		$.post("ServiceDup.php",{},SetContent);
	});
	$("#mSSync").click(function(){
		$("#spinner").show();
		$.post("ServiceSync.php",{},SetContent);
	});
	$("#mSRate").click(function(){
		window.open("ServiceRating.html", "_blank");
	});
}

function SetContent(data,status,xhr)
{
	if ($('#nextVideo').length != 0){
		$('#nextVideo').remove();
		$('#movieLibraryContainer').append(data);
	}
	else if ($('#nextMovie').length != 0){
		$('#nextMovie').remove();
		$('#movieLibraryContainer').append(data);
	}
	else $('#content').html(data);
	ToggleDetails();
	TogglePlayed();
	$("#spinner").hide();
	$(".cVAdd").click(function(event){
		event.stopPropagation();
		$("#spinner").show();
		$.post("InsertVideo.php",{id:$(this).data("id")},CheckResult);
		$(this).addClass('cActive');
	});
	$(".cUpd").click(function(event){
		event.stopPropagation();
		$("#spinner").show();
		$.post("UpdateVideo.php",{id:$(this).data("id"),idStatus:$(this).data("state")},CheckResult);
		$(this).parent().children(".cUpd").each(function(){$(this).removeClass('cActive')});
		if ($(this).data("state")) $(this).addClass('cActive');
	});
	$(".cDel").click(function(event){
		event.stopPropagation();
		$("#spinner").show();
		$.post("DeleteVideo.php",{id:$(this).data("id")},CheckResult);
		$(this).hide();
	});
	$(".videoPoster").click(function(){
		$("#overlay").show();
		$("#details").show();
		$.post("ShowVideo.php",{id:$(this).data("id")},SetDetails);
	});
	$(".moviePoster").click(function(){
		$("#overlay").show();
		$("#details").show();
		$.post("ShowMovie.php",{id:$(this).data("id")},SetDetails);
	});
	$("#nextVideo").click(function(){
		$("#spinner").show();
		$.post("ListVideo.php",{next:1},SetContent);
	});
	$("#nextMovie").click(function(){
		$("#spinner").show();
		$.post("ListMovie.php",{next:1},SetContent);
	});
	$("#bTSearch").click(function(){
		$("#spinner").show();
		$.post("SearchTMDB.php",{cTitle:$("#cTSearch").val()},SetContent);
	});
    $('#cTSearch').keyup(function(e) {
    if (e.keyCode == 13) {
		$("#spinner").show();
		$.post("SearchTMDB.php",{cTitle:$(this).val()},SetContent);
    }
    });
}

function SetDetails(data,status,xhr)
{
	$('#details').html(data);
}


function CheckResult(data,status,xhr)
{
	$("#spinner").hide();
//	if (data != "" && data != null) alert(data);
	if (data && data.length>2)
	{
		s = "#"+data+"#"+data.length;
		alert(s);	
	}
//	$('#content').append('<script>console.log("'+data+'")</script>');
}

function ToggleDetails()
{
	if ($('#vDetail').hasClass('selected'))

	{
		$('.divTST').width('100%').height('290px');
		$('.desc').hide();
		$('.movieDetail').show();
	}
	else
	{
		$('.divTST').width('207px').height('320px');
		$('.movieDetail').hide();
		$('.desc').show();
	}
}

function TogglePlayed()
{
	if ($('#vPlayed').hasClass('selected'))
	{
		$('.cPlayed').show();
	}
	else
	{
		$('.cPlayed').hide();
	}
}

function AddFav(idMovie)
{
	if (FavList == "")
	{
		FavList = idMovie;
	}
	else
	{
		FavList = FavList + "," + idMovie;
	}
}


$(document).ready(function(){
	$("#details").click(function(){
		$('#details').empty().hide();
		$('#overlay').hide();
	});
	$("#vMovie").click(function(){
		$('#vVideo').removeClass('selected');
		$('#mVideo').hide();
		$('#vMovie').addClass('selected');
		$('#mMovie').show();
		$('#vFavorit').removeClass('selected');
		$('#content').empty();
	});
	$("#vVideo").click(function(){
		$('#vMovie').removeClass('selected');
		$('#mMovie').hide();
		$('#vVideo').addClass('selected');
		$('#mVideo').show();
		$('#vFavorit').removeClass('selected');
		$('#content').empty();
	});
	$("#vFavorit").click(function(){
		$('#vMovie').removeClass('selected');
		$('#mMovie').hide();
		$('#vVideo').removeClass('selected');
		$('#mVideo').hide();
		$('#vFavorit').addClass('selected');
		$('#content').empty();
		$.post("ListMovie.php",{idMovie: FavList},SetContent);
	});
	$("#vDetail").click(function(){
		$(this).toggleClass('selected');
		ToggleDetails();
	});
	$("#vPlayed").click(function(){
		$(this).toggleClass('selected');
		TogglePlayed();
	});
	$("#mXDate").click(function(){
		$.post("MenuXDate.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mXTitle").click(function(){
		$.post("MenuXTitle.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mXGenre").click(function(){
		$.post("MenuXGenre.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mXTag").click(function(){
		$.post("MenuXTag.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mXRating").click(function(){
		$.post("MenuXRating.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mXService").click(function(){
		$.post("MenuService.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mTStatus").click(function(){
		$.post("MenuVStatus.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mTTitle").click(function(){
		$.post("MenuVTitle.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mTGenre").click(function(){
		$.post("MenuVGenre.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mTRating").click(function(){
		$.post("MenuVRating.php",{},SetNavigation);
		ResetMenu($(this));
	});
	$("#mTService").click(function(){
		$.post("MenuService.php",{},SetNavigation);
		ResetMenu($(this));
	});

	$("#mTNew").click(function(){
		$.post("SearchTMDB.php",{},SetContent);
		ResetMenu($(this));
	});
//	$("#vMovie").click();
});