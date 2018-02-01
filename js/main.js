$(document).ready(function(){
 $('.btnMore').click(function(){
  $(this).parent().children('div.detailsRoute').toggle('normal');
  return false;
 });
});