package com.modelo.dao;

import java.util.List;
import com.modelo.entidades.Usuario;
import jakarta.persistence.EntityManager;
import jakarta.persistence.Persistence;
import jakarta.persistence.Query;

public class UsuarioDAO {

	// Entity Manager para persistencia
	private EntityManager em;


	public UsuarioDAO() {
		this.em = Persistence.createEntityManagerFactory("persistencia").createEntityManager();
	}

	
	/*********** Metodos de Negocio ******/

	public Usuario authenticate(String username, String password) {
		String _SQL_AUTORIZAR_ = "SELECT u FROM Usuario u WHERE nombre= :nombre and clave= :clave";
		Query query = this.em.createQuery(_SQL_AUTORIZAR_);
		query.setParameter("nombre", username);
		query.setParameter("clave", password);
		return (Usuario) query.getSingleResult();
	}

	@SuppressWarnings("unchecked")
	public List<Usuario> getUsuarios() {
		String _SQL_AUTORIZAR_ = "SELECT u FROM Usuario u";
		Query query = this.em.createQuery(_SQL_AUTORIZAR_);
		return (List<Usuario>) query.getResultList();
	}

	public Usuario getUsuarioById(int idUsuario) {
		
		return this.em.find(Usuario.class, idUsuario);
	}

	public boolean create(Usuario usuario) {
		this.em.getTransaction().begin();
		try {			
			this.em.persist(usuario);
			this.em.getTransaction().commit();
			return true;
		}catch(Exception e) {
			System.out.println(">>>> ERROR:UsuarioDAO:create " + e);
			if (this.em.getTransaction().isActive())
				this.em.getTransaction().rollback();
			return false;
		}
	}

	public boolean update(Usuario usuario) {

		this.em.getTransaction().begin();
		try {			
			this.em.merge(usuario);
			this.em.getTransaction().commit();
			return true;
		}catch(Exception e) {
			System.out.println(">>>> ERROR:UsuarioDAO:update " + e);
			if (this.em.getTransaction().isActive())
				this.em.getTransaction().rollback();
			return false;
		}
	}

	public boolean delete(int idUsuario) {
		Usuario u = this.getUsuarioById(idUsuario);
		this.em.getTransaction().begin();
		try {			
			this.em.remove(u);
			this.em.getTransaction().commit();
			return true;
		}catch(Exception e) {
			System.out.println(">>>> ERROR:UsuarioDAO:delete " + e);
			if (this.em.getTransaction().isActive())
				this.em.getTransaction().rollback();
			return false;
		}
	}

}
