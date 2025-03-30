<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

localStorage.removeItem('authToken')
localStorage.removeItem('authUserName')

router.push('/login')

</script>