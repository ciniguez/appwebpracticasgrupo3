<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="jakarta.tags.core"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>

	<h1>Lista de Personas</h1>
	<table>
		<thead>
			<tr>
				<th>Cédula</th>
				<th>Nombre</th>
				<th>Apellido</th>
			</tr>
		</thead>
		<tbody>
			<c:forEach var="persona" items="${personitas}">
				<tr>
					<td>${persona.cedula}</td>
					<td>${persona.nombre}</td>
					<td>${persona.apellido}</td>
				</tr>
			</c:forEach>

		</tbody>
	</table>

</body>
</html>